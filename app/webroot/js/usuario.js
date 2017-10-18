function ViajeSocket (viaje_id) {
    this.viaje_id = viaje_id;
}

ViajeSocket.prototype.connect = function() {
    this.socket = io(window.NODE_EVENT_SERVER_URL + '?viaje_id=' + this.viaje_id);
    return this.socket;
};

$(document).ready(function(){
    $('.alert-container').on('click', '.alert', function(){
        $(this).fadeOut(500, function(){
            $(this).remove();
        });
    });
    setTimeout(function(){
        $('.alert-container .alert').click();
    }, 60000);
});