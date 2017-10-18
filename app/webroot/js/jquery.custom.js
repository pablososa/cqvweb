function randomString() {
    var str = '';
    for (var i = 0; i < 5; i++) {
        str += Math.random().toString(36).replace(/[^a-z]+/g, '');
    }
    return str;
}
$('.alert').click(function () {
    $(this).slideUp();
});
$.fn.directionSearch = function (direction) {
    var dom_id = $(this).attr('id');
    if (!dom_id) {
        dom_id = randomString();
        $(this).attr('id', dom_id);
    }
    if (!direction) {
        direction = $(this).data('direction');
    }
    if (typeof google == 'undefined') {
        google = window.top.google;
    }
    if (typeof google !== 'undefined') {
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'address': direction}, function (results) {
            var lat = parseFloat(results[0].geometry.location.lat());
            var lng = parseFloat(results[0].geometry.location.lng());
            var sw = new google.maps.LatLng(lat - 1, lng - 1);
            var ne = new google.maps.LatLng(lat + 1, lng + 1);
            var centerPlace = new google.maps.LatLngBounds(sw, ne);

            var options = {
                //types: ['geocode'],
                bounds: centerPlace
            };
            var location_being_changed,
                input = document.getElementById(dom_id),
                autocomplete = new google.maps.places.Autocomplete(input, options),
                onPlaceChange = function () {
                    location_being_changed = false;
                };

            google.maps.event.addListener(autocomplete,
                'place_changed',
                onPlaceChange);

            google.maps.event.addDomListener(input, 'keydown', function (e) {
                if (e.keyCode === 13) {
                    if (location_being_changed) {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                } else {
                    // means the user is probably typing
                    location_being_changed = true;
                }
            });
        });
    }
};
window.apptaxiweb = {};
window.apptaxiweb.popup = function (url, options) {
    var options_default = {
        width: 500,
        height: 300,
        modal: true,
        title: 'Popup',
        closeable: true,
        position: {my: "top", at: "top", of: 'section:first'}
    };
    for (var key in options) {
        options_default[key] = options[key];
    }
    if (!options_default.closeable) {
        options_default.open = function (event, ui) {
            $('.ui-dialog-titlebar-close').hide();
        };
    }
    url += '/isIframe:1';
    var iframe = $('<iframe>');
    iframe.attr('src', url);
    var dialog = $('<div>');
    dialog.attr('id', 'dialog');
    dialog.attr('title', options_default.title);
    dialog.append(iframe);
    $('body:first').append(dialog);
    dialog.dialog(options_default);

    var top = parseInt($(dialog).closest('.ui-dialog').css('top').replace('px', '')) + 25;
    $(dialog).closest('.ui-dialog').css('top', '' + top + 'px');
};
$.fn.targetSlideDown2 = function () {
    return;
    $(this).each(function () {
        var $this = $(this);
        if ($this.is('a') && typeof $this.data('target-slide-down-inited') == 'undefined') {
            $this.data('target-slide-down-inited', true);
            var current_tr = $this.closest('tr');
            var tr = $('<tr>').addClass('slide-down')
            var td = $('<td>');
            tr.append(td);
            var div = $('<div>').addClass('slide-down');
            td.append(div);
            td.attr('colspan', $this.closest('tr').find('td').length);
            $this.click(function (e) {
                e.preventDefault();
                if ($this.hasClass('slided-down')) {
                    tr.remove();
                    $this.removeClass('slided-down');
                } else {
                    if (current_tr.next().hasClass('slide-down')) {
                        current_tr.next().remove();
                        current_tr.find('.slided-down').removeClass('slided-down');
                        current_tr.find('.slided-down-fixed').removeClass('slided-down-fixed');
                    }
                    current_tr.after(tr);
                    tr = current_tr.next();
                    var options = {
                        url: $this.attr('href'),
                        success: function (data) {
                            div.html(data)
                        }
                    };
                    $.ajax(options);
                    $this.addClass('slided-down');
                }
            });
        }
    });
};

$(document).ready(function () {
    $('body').on('click', 'a.slide-down-target, a.slide-down-fixed', function (e) {
        e.preventDefault();
        var $this = $(this);
        var $current_tr = $this.closest('tr');
        var td, tr;

        if($current_tr.next().hasClass('hidden-fixed-slide-down')) {
            var td = $current_tr.next().find('td:first').clone();
            $current_tr.next().remove();
            td.hide();
            td.addClass('fixed-slide-down-data');
            $current_tr.append(td);
        }
        if ($current_tr.next().hasClass('slide-down')) {
            $current_tr.next().remove();
        }
        if ($this.hasClass('slide-down-fixed')) {
            if ($this.hasClass('slide-down-fixed-slided')) {
                $this.removeClass('slide-down-fixed-slided');
            } else {
                $current_tr.find('.slide-down-fixed-slided').removeClass('slide-down-fixed-slided');
                $current_tr.find('.slide-down-target-slided').removeClass('slide-down-target-slided');
                $this.addClass('slide-down-fixed-slided');
                td = $current_tr.find('.fixed-slide-down-data').clone();
                td.show();
                tr = $('<tr>').addClass('slide-down');
                td.attr('colspan', $current_tr.find('td:not(.fixed-slide-down-data)').length)
                tr.append(td);
                $current_tr.after(tr);
            }
        } else if ($this.hasClass('slide-down-target')) {
            if ($this.hasClass('slide-down-target-slided')) {
                $this.removeClass('slide-down-target-slided');
            } else {
                $current_tr.find('.slide-down-fixed-slided').removeClass('slide-down-fixed-slided');
                $current_tr.find('.slide-down-target-slided').removeClass('slide-down-target-slided');
                $this.addClass('slide-down-target-slided');

                tr = $('<tr>').addClass('slide-down')
                td = $('<td>');
                var div = $('<div>').addClass('slide-down');
                td.attr('colspan', $current_tr.find('td:not(.fixed-slide-down-data)').length)
                td.append(div);
                tr.append(td);
                $current_tr.after(tr);

                var options = {
                    url: $this.attr('href'),
                    success: function (data) {
                        div.html(data)
                    }
                };
                $.ajax(options);
            }
        }
    });
});

$.fn.fixedSlideDown2 = function () {
    return;
    $(this).each(function () {
        var $this = $(this);
        if ($this.is('a')) {
            var div;
            var current_tr = $this.closest('tr');
            var tr = current_tr.next();
            tr.addClass('slide-down');
            var td = tr.find('td:first');
            td.find('div:first').addClass('slide-down');
            td.attr('colspan', $this.closest('tr').find('td').length);
            tr.show();
            //tr.remove();
            console.log(tr);
            $this.click(function (e) {
                e.preventDefault();
                if (!$this.hasClass('disabled')) {
                    if ($this.hasClass('slided-down-fixed')) {
                        tr.remove();
                        $this.removeClass('slided-down-fixed');
                    } else {
                        console.log('culo!');
                        console.log(current_tr.next());
                        //if(current_tr.next().hasClass('slide-down')) {
                        //    current_tr.next().remove();
                        //    current_tr.find('.slided-down-fixed').removeClass('slided-down-fixed');
                        //    current_tr.find('.slided-down').removeClass('slided-down');
                        //}
                        current_tr.after(tr);
                        $this.addClass('slided-down-fixed');
                    }
                }
            });
        }
    });
};
window.apptaxiweb.redirect = function (url) {
    if (!url) {
        top.window.location.reload();
    } else {
        top.window.location = url;
    }
};