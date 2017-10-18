$(document).ready(function () {
    window.has_panic_been_shown = false;
    var container = $('.mensajes-container');
    if (container.length > 0) {
        //$('body:first').append(container);
        $('#msn').append(container);
        var container_ul = container.find('ul');

        function doMagic(first_call) {
            first_call = (typeof first_call !== 'undefined' && first_call === true) ? '/1' : '';
            var options = {
                url: container.find('a.js-ajax-url').prop('href') + first_call,
                success: function (data) {
                    if (data) {
                        container_ul.unseen_ids = [];
                        if (data.has_unseen > 0) {
                            popUp();
                        } else {
                            container_ul.find('li.unseen').removeClass('unseen');
                        }
                        if (data.messages.length > 0) {
                            container_ul.html('');
                            $.each(data.messages, function (index, value) {
                                createMensaje(value);
                            });
                        }
                        if (data.panic && !window.has_panic_been_shown) {
                            var options = {
                                title: 'Pánico',
                                width: 600,
                                height: 310,
                                closeable: false
                            };
                            window.apptaxiweb.popup('/localizacions/panico', options);
                            window.has_panic_been_shown = true;
                        }
                    }
                    setTimeout(doMagic, 15000);
                }
            };
            $.ajax(options);
        }

        container_ul.click(function () {
            if (container_ul.unseen_ids.length) {
                var url = container.find('a.js-ajax-url-accept').attr('href');
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        data: {
                            Mensaje: {
                                ids: $.extend({}, container_ul.unseen_ids)
                            }
                        }
                    }
                });
            }
            popDown();
        });
        function createMensaje(mensaje) {
            var sender = $('<div>')
                .addClass('sender')
                .html(mensaje.Vehiculo.nro_registro);
            var text = $('<div>')
                .addClass('text')
                .html(mensaje.Mensaje.texto);
            var date = $('<div>')
                .addClass('date')
                .html(mensaje.Mensaje.fecha);
            text.prepend(sender);
            var li = $('<li>')
                .addClass('mensaje')
//                    .append(sender)
                .append(text)
                .append(date);
            if (!mensaje.Mensaje.visto) {
                li.addClass('unseen');
                container_ul.unseen_ids.push(mensaje.Mensaje.id);
            }
            container_ul.append(li);
        }

        var css_back = false;

        function popUp(e) {
            if (!css_back) {
                css_back = container.css('right');
            }
            var options = {
                right: '0px'
            };
            container.stop();
            container.animate(options);
        }

        function popDown(e) {
            container.stop();
            container.animate({
                right: css_back
            });
        }

        container.mouseenter(popUp);
        container.mouseleave(popDown);
        window.subscribe('panic', doMagic);
        window.subscribe('new_message', doMagic);
        doMagic(true);
    }


});

window.subscribe = function (events, callback) {
    if (typeof window.socket == 'undefined') {
        window.socket = io(window.NODE_EVENT_SERVER_URL + '?empresa_id=' + window.empresa_id);
    }
    if (typeof events === 'string') {
        events = [events];
    }
    for (var i in events) {
        var event = events[i];
        window.socket.on(event, callback);
    }
};


function consultarReservas() {

    if (window.empresa_id == null || window.empresa_id == undefined) return;
    if (window.mostrado_refdif) return;

    $.ajax({
        url: '/empresas/getReservasDif',
        dataType: 'json',
        success: function (datos) {


            if (datos["hayresdif"] == 1) {
                if (getCookie("ResDif") == "1") return;
                window.mostrado_refdif = true;
                var options = {
                    title: 'Reserva diferida',
                    width: 600,
                    height: 310,
                    closeable: false
                };
                window.apptaxiweb.popup('/localizacions/resdif', options);
            } else {

                setCookie("ResDif", "0", 1)
            }


        },
        complete: function () {
            setTimeout(consultarReservas, 10000);
        }
    });

}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
    }
    return "";
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires + "; path=/";
    ;
}


function startMessages() {
    $('body:first').on('click', '.messages-board a[rel="next"]', function (event) {
        event.preventDefault();
        var $this = $(this);
        var options = {
            url: $this.attr('href'),
            success: function (data) {
                var $data = $(data);
                $this.closest('.messages-board').find('.all-messajes-container').append($data.find('.mensaje-cont'));
                $this.replaceWith($data.find('a[rel="next"]'));
            }
        };
        $.ajax(options);
    });
    $('a.slide-down').targetSlideDown();
}

var currentLocation = window.location;

if (currentLocation.href.indexOf("/empresas/reservation") < 0) {
    consultarReservas();
}
/*
 window.onbeforeunload = function() {
 var confirmar = confirm("Are you sure you want to close?");
 if(confirmar){
 return true;
 }else{
 return false;
 }
 }
 $(document).ready(function()
 {
 $(window).bind("beforeunload", function() {
 return confirm("Do you really want to close?");
 });
 });*/