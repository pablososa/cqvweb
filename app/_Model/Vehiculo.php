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
round(sum(v.tarifa),0) as total , 
round(sum(v.tarifa*(select comision/100 from apptaxi_vehiculos  where id = {$id} )),0) as comision,
round( IFNULL((select sum(monto) as pago  from apptaxi_vehiculo_pago where vehiculo_id = {$id} and dia = v.fecha),0),0) as pagos,
IFNULL((select DATE_FORMAT(fecha,'%d-%m-%Y') from apptaxi_vehiculo_pago where dia=v.fecha and vehiculo_id = {$id} order by id desc limit 1 ),'No realizada') as pago
from apptaxi_viajes v where v.vehiculo_id = {$id} group by fecha order by fecha desc;
SQL;

        $viajes = $this->query($qry);
        return $viajes;

    }


  public function getInicio(){

$eid = $_SESSION['Empresa']['Empresa']['id'];

 $qry = <<<SQL

select  'TOTAL FACTURADO' as descripcion, round(sum(v.tarifa * (vv.comision/100)),0) as total from apptaxi_viajes v
inner join apptaxi_vehiculos vv on v.vehiculo_id = vv.id
where v.estado = 'Finalizado' and v.empresa_id = {$eid}
UNION
select 'TOTAL DE PAGOS' as descripcion,IFNULL( round(sum(monto),0) , 0 ) as total from apptaxi_vehiculo_pago where 
vehiculo_id in (select id from apptaxi_vehiculos where empresa_id={$eid})
UNION
select 'TOTAL POR COBRAR' as descripcion,
round((
(select round(sum(v.tarifa * (vv.comision/100)),0) from apptaxi_viajes v
inner join apptaxi_vehiculos vv on v.vehiculo_id = vv.id
where v.estado = 'Finalizado' and v.empresa_id = {$eid}) - (select IFNULL( round(sum(monto),0) , 0 ) as total from apptaxi_vehiculo_pago where 
vehiculo_id in (select id from apptaxi_vehiculos where empresa_id={$eid}))
),0) as total

SQL;
        $viajes = $this->query($qry);
      
        return $viajes;

    }

  public function getFacturacion($fi,$ff){

    $eid = $_SESSION['Empresa']['Empresa']['id'];

if ($ff!=null){
 $qry = <<<SQL
select  'TOTAL FACTURADO' as descripcion, round(sum(v.tarifa * (vv.comision/100)),0) as total from apptaxi_viajes v
inner join apptaxi_vehiculos vv on v.vehiculo_id = vv.id
where v.estado = 'Finalizado' and v.empresa_id = {$eid}
and v.fecha >= '{$fi}'
and v.fecha <= '{$ff}'
UNION
select 'TOTAL DE PAGOS' as descripcion,IFNULL( round(sum(monto),0 , 0 ) as total from apptaxi_vehiculo_pago where 
vehiculo_id in (select id from apptaxi_vehiculos where empresa_id={$eid})
and dia >= '{$fi}'
and dia <= '{$ff}'
UNION
select 'TOTAL POR COBRAR' as descripcion,
round((
(select round(sum(v.tarifa * (vv.comision/100)),0) from apptaxi_viajes v
inner join apptaxi_vehiculos vv on v.vehiculo_id = vv.id
where v.estado = 'Finalizado' and v.empresa_id = {$eid} and v.fecha >= '{$fi}' and v.fecha <= '{$ff}' ) - (select IFNULL( round(sum(monto),0) , 0 ) as total from apptaxi_vehiculo_pago where 
vehiculo_id in (select id from apptaxi_vehiculos where empresa_id={$eid} and dia >= '{$fi}'  and dia <= '{$ff}' ))
),0) as total
SQL;
}
else {
 $qry = <<<SQL
select  'TOTAL FACTURADO' as descripcion, round(sum(v.tarifa * (vv.comision/100)),0) as total from apptaxi_viajes v
inner join apptaxi_vehiculos vv on v.vehiculo_id = vv.id
where v.estado = 'Finalizado' and v.empresa_id = {$eid}
and v.fecha >= '{$fi}'
UNION
select 'TOTAL DE PAGOS' as descripcion,IFNULL( round(sum(monto),0) , 0 ) as total from apptaxi_vehiculo_pago where 
vehiculo_id in (select id from apptaxi_vehiculos where empresa_id={$eid})
and dia >= '{$fi}'
UNION
select 'TOTAL POR COBRAR' as descripcion,
round((
(select round(sum(v.tarifa * (vv.comision/100)),0) from apptaxi_viajes v
inner join apptaxi_vehiculos vv on v.vehiculo_id = vv.id
where v.estado = 'Finalizado' and v.empresa_id = {$eid} and v.fecha >= '{$fi}') - (select IFNULL( round(sum(monto),0) , 0 ) as total from apptaxi_vehiculo_pago where 
vehiculo_id in (select id from apptaxi_vehiculos where empresa_id={$eid} and dia >= '{$fi}' ))
),0) as total
SQL;

}

        $viajes = $this->query($qry);
      
        return $viajes;

    }
    



    public function setLiquidacion($id,$fecha,$monto){

 $qry = <<<SQL
        INSERT INTO apptaxi_vehiculo_pago (vehiculo_id,dia,fecha,monto) values({$id},'{$fecha}',NOW(),{$monto})
SQL;

        $this->query($qry);
        
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
