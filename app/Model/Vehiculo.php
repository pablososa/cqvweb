<?php

class Vehiculo extends AppModel {

    var $name = 'Vehiculo';
    var $hasOne = array(
        'Localizacion' => array(
            'className' => 'Localizacion',
            'foreignKey' => 'vehiculo_id',
            'dependent' => true
        )
    );
    var $belongsTo = array(
        'Empresa' => array(
            'className' => 'Empresa',
            'foreignKey' => 'empresa_id'
        )
    );
    var $hasMany = array(
        'Viaje' => array(
            'className' => 'Viaje',
            'foreignKey' => 'vehiculo_id',
            'dependent' => true
        ),
        'Historialvc' => array(
            'className' => 'Historialvc',
            'foreignKey' => 'vehiculo_id',
            'dependent' => true
        )
    );
    var $validate = array(
        'marca' => array(
            'no_vacio' => array(
                'rule' => 'notEmpty',
                'message' => 'Debe ingresar la marca del vehiculo.'
            ),
            'tipo' => array(
                'rule' => array(
                    'custom',
                    '<[a-zA-ZñÑ\s]{2,50}>'
                ),
                'message' => 'La marca del vehiculo debe contener solo letras.'
            )
        ),
        'modelo' => array(
            'no_vacio' => array(
                'rule' => 'notEmpty',
                'message' => 'Debe ingresar el modelo del vehiculo.'
            ),
            'tipo' => array(
                'rule' => 'alphanumeric'
            )
        ),
        'patente' => array(
            'no_vacio' => array(
                'rule' => 'notEmpty',
                'message' => 'Debe ingresar la patente del vehiculo.'
            ),
            'es_unico' => array(
                'rule' => array('isUniqueNPatente'),
                'message' => 'Ya existe un vehiculo registrado con esa patente.'
            ),
            /*'tipo' => array(
                'rule' => array(
                    'custom',
                    '<[a-zA-Z]{3}\d{3}>'
                ),
                'message' => 'La patente del vehiculo debe contener primero 3 letras y luego 3 números (ej: AAA111).'
            )*/
        'tipo' => array(
                'rule' => 'alphanumeric'
            )
        ),
        'nro_registro' => array(
            'no_vacio' => array(
                'rule' => 'notEmpty',
                'message' => 'Debe ingresar el numero de registro del vehiculo.'
            ),
            'es_unico' => array(
                'rule' => array('isUniqueNMobile'),
                'message' => 'Ya existe un vehiculo registrado con ese número de móvil.'
            )
        )
    );

    function isUniqueNPatente($data) {
        $id = !empty($this->data['Vehiculo']['id']) ? $this->data['Vehiculo']['id'] : -1;
        $options = array(
            'conditions' => array(
                'Vehiculo.patente' => $data['patente'],
                'Vehiculo.empresa_id' => $_SESSION['Empresa']['Empresa']['id'],
                'Vehiculo.id !=' => $id,
                'Vehiculo.habilitado !=' => 'Eliminado'
            ),
        );
        $vehiculo = $this->find('first', $options);
        return empty($vehiculo);
    }
    
    function isUniqueNMobile($data) {
        $id = !empty($this->data['Vehiculo']['id']) ? $this->data['Vehiculo']['id'] : -1;
        $options = array(
            'conditions' => array(
                'Vehiculo.nro_registro' => $data['nro_registro'],
                'Vehiculo.empresa_id' => $_SESSION['Empresa']['Empresa']['id'],
                'Vehiculo.id !=' => $id,
                'Vehiculo.habilitado !=' => 'Eliminado'
            ),
        );
        $vehiculo = $this->find('first', $options);
        return empty($vehiculo);
    }

    function activar($id) {
        $this->id = $id;
        return $this->saveField('habilitado', 'Habilitado');
    }

    function desactivar($id) {
        $this->id = $id;
        return $this->saveField('habilitado', 'Deshabilitado');
    }

    public function afterSave($created, $options = array()) {
        parent::afterSave($created, $options);
        if ($created) {
            $address = str_replace(" ", "+", $this->data['Vehiculo']['direccion']);
            $region = "ARG";
            $json = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyDWz5paGiK-oElR-T2B8agIYktwhTEQvJA&address=$address&sensor=false&region=$region");
            $json = json_decode($json);
            $lat = $json->{'results'}['0']->{'geometry'}->{'location'}->{'lat'};
            $long = $json->{'results'}['0']->{'geometry'}->{'location'}->{'lng'};
            $array['Localizacion']['vehiculo_id'] = $this->data['Vehiculo']['id'];
            $array['Localizacion']['latitud'] = $lat;
            $array['Localizacion']['longitud'] = $long;
            $array['Localizacion']['estado'] = 'Fuera_de_linea';
            $this->Localizacion->save($array);
        }
    }

    public function calificacion($id) {
        $viajes = $this->Viaje->findByVehiculoId($id);
        $calificacion = 0;
        foreach ($viajes as $viaje):
            $calificacion += $this->Viaje->calificacionVehiculo($viaje['Viaje']['id']);
        endForeach;
        if (count($viajes) != 0) {
            $calificacion /= count($viajes);
        }
        return $calificacion;
    }

    public function getLiquidacion($id){


 $qry = <<<SQL
select 
v.fecha, 
round(sum(v.tarifa),2) as total , 
round(sum(v.tarifa*(select comision/100 from apptaxi_vehiculos  where id = {$id} )),2) as comision,
IFNULL((select sum(monto) as pago  from apptaxi_vehiculo_pago where vehiculo_id = {$id} and dia = v.fecha),0) as pagos,
IFNULL((select DATE_FORMAT(fecha,'%d-%m-%Y') from apptaxi_vehiculo_pago where dia=v.fecha and vehiculo_id = {$id} order by id desc limit 1 ),'No realizada') as pago
from apptaxi_viajes v where v.vehiculo_id = {$id} group by fecha order by fecha desc;
SQL;

        $viajes = $this->query($qry);
        return $viajes;

    }


  public function getInicio(){

$eid = $_SESSION['Empresa']['Empresa']['id'];

 $qry = <<<SQL

select  'TOTAL EFECTIVO' as descripcion, 0 as total 
UNION
select  'TOTAL CUENTA CORRIENTE' as descripcion, 0 as total 
UNION
select  'TOTAL COMISIONES' as descripcion, 0 as total 
UNION
select 'TOTAL DE PAGOS RECIBIDOS' as descripcion,0 as total
UNION
select 'TOTAL POR COBRAR' as descripcion,0 as total
SQL;
        $viajes = $this->query($qry);
      
        return $viajes;

    }

  public function getFacturacion($fi,$ff){

    $eid = $_SESSION['Empresa']['Empresa']['id'];

if ($ff!=null){
 $qry = <<<SQL
 select  'TOTAL EFECTIVO' as descripcion, round(sum(v.tarifa ),0) as total from apptaxi_viajes v
inner join apptaxi_vehiculos vv on v.vehiculo_id = vv.id
where v.estado = 'Finalizado' and v.empresa_id = {$eid}
and v.fecha >= '{$fi}'
and v.fecha <= '{$ff}'
UNION
select  'TOTAL CUENTA CORRIENTE' as descripcion, round(sum(v.tarifa ),0) as total from apptaxi_viajes v
inner join apptaxi_vehiculos vv on v.vehiculo_id = vv.id
where v.estado = 'Finalizado' and v.empresa_id = {$eid}
and v.fecha >= '{$fi}'
and v.fecha <= '{$ff}'
and v.creador = "Usuario"
UNION
select  'TOTAL COMISIONES' as descripcion, round(sum(v.tarifa * (vv.comision/100)),0) as total from apptaxi_viajes v
inner join apptaxi_vehiculos vv on v.vehiculo_id = vv.id
where v.estado = 'Finalizado' and v.empresa_id = {$eid}
and v.fecha >= '{$fi}'
and v.fecha <= '{$ff}'
UNION
select 'TOTAL DE PAGOS RECIBIDOS' as descripcion,IFNULL( round(sum(monto),0) , 0 ) as total from apptaxi_vehiculo_pago where 
vehiculo_id in (select id from apptaxi_vehiculos where empresa_id={$eid})
and dia >= '{$fi}'
and dia <= '{$ff}'
UNION
select 'TOTAL POR COBRAR' as descripcion,
0 as total
SQL;
}
else {
 $qry = <<<SQL
select  'TOTAL EFECTIVO' as descripcion, round(sum(v.tarifa ),0) as total from apptaxi_viajes v
inner join apptaxi_vehiculos vv on v.vehiculo_id = vv.id
where v.estado = 'Finalizado' and v.empresa_id = {$eid}
and v.fecha >= '{$fi}'
UNION
select  'TOTAL CUENTA CORRIENTE' as descripcion, round(sum(v.tarifa ),0) as total from apptaxi_viajes v
inner join apptaxi_vehiculos vv on v.vehiculo_id = vv.id
where v.estado = 'Finalizado' and v.empresa_id = {$eid}
and v.fecha >= '{$fi}' 
and v.creador = "Usuario"
UNION
select  'TOTAL COMISIONES' as descripcion, round(sum(v.tarifa * (vv.comision/100)),0) as total from apptaxi_viajes v
inner join apptaxi_vehiculos vv on v.vehiculo_id = vv.id
where v.estado = 'Finalizado' and v.empresa_id = {$eid}
and v.fecha >= '{$fi}'
UNION
select 'TOTAL DE PAGOS RECIBIDOS' as descripcion,IFNULL( round(sum(monto),0) , 0 ) as total from apptaxi_vehiculo_pago where 
vehiculo_id in (select id from apptaxi_vehiculos where empresa_id={$eid})
and dia >= '{$fi}'
UNION
select 'TOTAL POR COBRAR' as descripcion,
0 as total
SQL;

}

        $viajes = $this->query($qry);
      
        return $viajes;

    }


  public function getDetalle($fi,$ff,$hini,$hfin){

    $eid = $_SESSION['Empresa']['Empresa']['id'];
if ($hini=="") $hini = "00:00";
if ($hfin=="") $hfin = "23:59";

$hini = $hini.":00";
$hfin = $hfin.":00";


if ($ff!=null){
 $qry = <<<SQL
SELECT v.id,v.nro_registro,
(select round(sum(vi.tarifa+vi.espera_monto),0) from apptaxi_viajes vi where vi.vehiculo_id = v.id and vi.estado = "Finalizado" and vi.fecha >= '{$fi}'
and vi.fecha <= '{$ff}' and vi.hora  and CAST(vi.hora as time) > CAST('{$hini}' as time) and CAST(vi.hora as time) < CAST('{$hfin}' as time) ) as monto,
(select round(sum( (vi.tarifa+vi.espera_monto)  ),0) from apptaxi_viajes vi where vi.vehiculo_id = v.id and vi.creador="Usuario" and vi.estado = "Finalizado"
 and vi.fecha <= '{$ff}' and CAST(vi.hora as time) > CAST('{$hini}' as time) and CAST(vi.hora as time) < CAST('{$hfin}' as time) ) as cc,

(select round(sum( (vi.tarifa+vi.espera_monto) * (v.comision/100) ),0) from apptaxi_viajes vi where vi.vehiculo_id = v.id and vi.creador="Usuario" and vi.estado = "Finalizado"
 and vi.fecha <= '{$ff}' and CAST(vi.hora as time) > CAST('{$hini}' as time) and CAST(vi.hora as time) < CAST('{$hfin}' as time) ) as cccoef,

(select round(sum( (vi.tarifa+vi.espera_monto) * (v.comision/100) ),0) from apptaxi_viajes vi where vi.vehiculo_id = v.id and vi.estado = "Finalizado" and vi.fecha >= '{$fi}'
and vi.fecha <= '{$ff}' and CAST(vi.hora as time) > CAST('{$hini}' as time) and CAST(vi.hora as time) < CAST('{$hfin}' as time) ) as comision,
IFNULL((select round(sum(monto),0) as pago  from apptaxi_vehiculo_pago where vehiculo_id = v.id ),0) as pagos 
  FROM apptaxi_vehiculos v
where v.empresa_id = {$eid}
and v.habilitado = "Habilitado" order by v.nro_registro asc
SQL;
}
else {
 $qry = <<<SQL
SELECT v.id,v.nro_registro,
(select round(sum(vi.tarifa+vi.espera_monto),0) from apptaxi_viajes vi where vi.vehiculo_id = v.id and vi.estado = "Finalizado" 
and vi.fecha <= '{$ff}') as monto,

(select round(sum( (vi.tarifa+vi.espera_monto)  ),0) from apptaxi_viajes vi where vi.vehiculo_id = v.id and vi.creador="Usuario" and vi.estado = "Finalizado"
 and vi.fecha <= '{$ff}' ) as cc,

(select round(sum( (vi.tarifa+vi.espera_monto) * (v.comision/100)  ),0) from apptaxi_viajes vi where vi.vehiculo_id = v.id and vi.creador="Usuario" and vi.estado = "Finalizado"
 and vi.fecha <= '{$ff}' ) as cccoef,

(select round(sum( (vi.tarifa+vi.espera_monto) * (v.comision/100) ),0) from apptaxi_viajes vi where vi.vehiculo_id = v.id and vi.estado = "Finalizado"
 and vi.fecha <= '{$ff}' ) as comision,
IFNULL((select round(sum(monto),0) as pago  from apptaxi_vehiculo_pago where vehiculo_id = v.id ),0) as pagos 
  FROM apptaxi_vehiculos v
where v.empresa_id = {$eid}
and v.habilitado = "Habilitado" order by v.nro_registro asc
SQL;

}



        $viajes = $this->query($qry);
      
        return $viajes;

    }





public function getMovimientos($fi,$ff){

$eid = $_SESSION['Empresa']['Empresa']['id'];

$qry = <<<SQL
SELECT fecha as fecha, detalle as detalle,monto as monto,usuario as usuario FROM apptaxi_movimientos where fecha >= '{$fi}' and fecha <= '{$ff}'
UNION
SELECT fecha as fecha, CONCAT('Rendición Vehiculo ',(SELECT nro_registro from apptaxi_vehiculos where id = apptaxi_vehiculo_pago.vehiculo_id ) ) as detalle,monto as monto,usuario as usuario FROM apptaxi_vehiculo_pago where  fecha >= '{$fi}' and fecha <= '{$ff}' 
order by fecha desc
SQL;

$viajes = $this->query($qry);
      
return $viajes;

}

public function getMovimientosIni(){

$eid = $_SESSION['Empresa']['Empresa']['id'];

$qry = <<<SQL
SELECT fecha as fecha, detalle as detalle,monto as monto,usuario as usuario FROM apptaxi_movimientos where DATE(fecha) = DATE(NOW())
UNION
SELECT fecha as fecha, CONCAT('Rendición Vehiculo ',(SELECT nro_registro from apptaxi_vehiculos where id = apptaxi_vehiculo_pago.vehiculo_id ) ) as detalle,monto as monto,usuario as usuario FROM apptaxi_vehiculo_pago WHERE DATE(fecha) = DATE(NOW())
order by fecha desc
SQL;

$viajes = $this->query($qry);
      
return $viajes;

}




  public function getDetalleIni(){

    $eid = $_SESSION['Empresa']['Empresa']['id'];

 $qry = <<<SQL
SELECT v.id,v.nro_registro,
0 as monto,
0 as comision,
0 as pagos 
  FROM apptaxi_vehiculos v
where v.empresa_id = {$eid}
and v.habilitado = "Habilitado" order by v.nro_registro asc
SQL;


        $viajes = $this->query($qry);
      
        return $viajes;

    }
    

 public function deleteIVR($empresa_id,$telefono){

    $eid = $_SESSION['Empresa']['Empresa']['id'];

if ($ff!=null){
 $qry = <<<SQL
 DELETE FROM apptaxi_XXXXX where empresa_id = {$empresa_id} AND telefono = '{$telefono}' 
SQL;

}

        $viajes = $this->query($qry);
      
        return $viajes;

    }


    public function setLiquidacion($id,$fecha,$monto,$usr){
 $qry = <<<SQL
        INSERT INTO apptaxi_vehiculo_pago (vehiculo_id,dia,fecha,monto,usuario) values({$id},'{$fecha}',NOW(),{$monto},'{$usr}')
SQL;

        $this->query($qry);
        
        return true;

    }



public function setMov($fecha,$det,$monto,$usr){

$qry = <<<SQL
INSERT INTO apptaxi_movimientos (fecha,detalle,monto,usuario) values('{$fecha}','{$det}',{$monto},'{$usr}')
SQL;


        $this->query($qry);
        return true;


}


public function setLiqRango($id,$fechaini,$fechafin,$monto,$usr){

$fecha1 =$fechaini;
$fecha2 = $fechafin;
$c = 0;
for($i=$fecha1;$i<=$fecha2;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){
    $c++;
}
$monto = $monto / $c;

for($i=$fecha1;$i<=$fecha2;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){
        $qry = <<<SQL
        INSERT INTO apptaxi_vehiculo_pago (vehiculo_id,dia,fecha,monto,usuario) values({$id},'{$i}',NOW(),{$monto},'{$usr}')
SQL;

        $this->query($qry);

}

        
        return true;

    }
    
    public function uploadThumb($file, $conductor_id) {
        return parent::__uploadThumb($file, $conductor_id, PATH_CONDUCTOR_THUMBS, 160, 160);
    }

    public function resetThumb($conductor_id) {
        $result = true;
        $path = PATH_CONDUCTOR_THUMBS . DS . $conductor_id . DS . 'thumb.png';
        if (file_exists($path)) {
            $result = unlink($path);
        }
        return $result;
    }

}
