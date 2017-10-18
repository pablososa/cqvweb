<script type="text/javascript">
    function ir_a_reservas(){

    if($('#chkresdif').attr('checked')=="checked") {
        
        setCook("ResDif","1",1)    
    }

window.top.location.href = "/empresas/reservation"
}

function setCook(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    window.top.document.cookie = cname + "=" + cvalue + "; " + expires + "; path=/";;
}

</script>
<div class="panic">
    <section id="content">
        <div class="image">
        </div>
        <table class="text">
            <tr>
                <td>
                        <p>
                            Atención! Existen reservas que deben despacharse dentro de los pr&oacute;ximos 30 minutos!
                        </p>
                        <p>
                           <input type="checkbox" name="chkresdif" id="chkresdif" />&nbsp;No volver a mostrar este mensaje
                        </p>

                </td>
            </tr>
        </table>
        <div class="row text-center">
            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-default" onclick="javascript:ir_a_reservas()">Ir a Reservas</button>
            </div>
        </div>
    </section>
</div>