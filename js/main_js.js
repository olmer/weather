/**
 * Created by JetBrains PhpStorm.
 * User: Olmer
 * Date: 20.06.11
 * Time: 16:42
 */
$(function() {
    var dialog  = $('#dialog');
    dialog.dialog({position: 'left', resizable: false, width: 184, height: 173});
    dialog.dialog('open');
    var dropdown = $('#dropdown');
    var checkbox_checked = false;
    $('table#details .td_content').css('display', 'none');
    $('#js_warning_enable').css('display', 'none');

    //Datepicker init
    $('td.date input,div.date_div input').datepicker({
        showOn: "both",
        buttonImage: "/styles/images/calendar_16x15.gif",
        buttonImageOnly: true,
        dateFormat: 'dd-mm-yy'
    }, $.datepicker.regional['']);

    //DropDown menu
    $('#drop_li').mouseenter(
            function() {
                dropdown.stop().slideDown('fast');
            }).mouseleave(function() {
                dropdown.stop().slideUp('fast');
            });

    //Form label hide on focus
    $("#main_info input, #transfer_table input, #translate_table input").focus(function() {
        $(this).parent().find("label").animate({
            width:0,
            opacity:0,
            left:"+=83"
        });
    });

    $("#main_info input, #transfer_table input, #translate_table input").focusout(function() {
        $(this).parent().find("label").animate({
            width:83,
            opacity:1,
            left:"-=83"
        });
    });

    //Form services details slide
    //Checkboxes details
    $('#details span.head input').click(
            function() {
                checkbox_checked = true;
            });

    $('#details span.head').click(function() {
        var a = $(this).children('input');
        var b = $(this).parent().find('div.td_content');
        if (!checkbox_checked) {
            if (a.attr('checked') === 'checked') {
                a.removeAttr('checked');
            }
            else {
                a.attr('checked', 'checked');
            }
        }
        checkbox_checked = false;
        if (a.attr('checked') === 'checked') {
            b.slideDown('fast');
        }
        else {
            b.slideUp('fast');
        }
    });

    //Show/hide various fields
    $('#details .td_content select').css('opacity', 0).change(function() {
        if (this.name === 'accomodation_type') {
            if (this.value === 'Apartment') {
                $('#number_childrens').parent().css('display', 'none');
            }
            else {
                $('#number_childrens').parent().css('display', 'block');
            }
        }
        else if (this.name === 'translate_type') {
            if (this.value === 'Translation') {
                $('#translate_duration').parent().parent().css('display', 'none');
            }
            else {
                $('#translate_duration').parent().parent().css('display', 'table-cell');
            }
        }
        $(this).parent().find('label').html($(this).val() +
                '<span class="l"></span><span class="r"></span><span class="arrow"></span>');
    });

    $('#input_transfer_from').change(function() {
        if (this.value === 'Airport "Borispol"' || this.value === 'Airport "Zhyliany"') {
            $('#td_flight_no').css('display', 'table-cell');
            $('#td_flight_no label').html('<span class="l"></span>Flight №');
        }
        else if (this.value === 'Other') {
            $('#td_flight_no').css('display', 'table-cell');
            $('#td_flight_no label').html('<span class="l"></span>From');
        }
        else {
            $('#td_flight_no').css('display', 'none');
        }
    });

    //Default fields values
    $('#input_price_from').focus(
            function() {
                if ($(this).val() === 'Price from') {
                    $(this).val('');
                }
            }).focusout(function() {
                if ($(this).val() === '') {
                    $(this).val('Price from');
                }
            });

    $('#input_time_arrival').focus(
            function() {
                if ($(this).val() === 'Arrival time') {
                    $(this).val('');
                }
            }).focusout(function() {
                if ($(this).val() === '') {
                    $(this).val('Arrival time');
                }
            });

    $('#other_suggestions').focus(
            function() {
                if ($(this).val() === 'Other wishes you may list here') {
                    $(this).val('');
                }
            }).focusout(function() {
                if ($(this).val() === '') {
                    $(this).val('Other wishes you may list here');
                }
            });

    $('#translate_duration').focus(
            function() {
                if ($(this).val() === 'Duration') {
                    $(this).val('');
                }
            }).focusout(function() {
                if ($(this).val() === '') {
                    $(this).val('Duration');
                }
            });

    $('#input_price_to').focus(
            function() {
                if ($(this).val() === 'Price to') {
                    $(this).val('');
                }
            }).focusout(function() {
                if ($(this).val() === '') {
                    $(this).val('Price to');
                }
            });
    $('#input_time_translate').focus(
            function() {
                if ($(this).val() === 'Time') {
                    $(this).val('');
                }
            }).focusout(function() {
                if ($(this).val() === '') {
                    $(this).val('Time');
                }
            });

    //Attach files
    $('#attachment').css('opacity', 0).mouseleave(function() {
        var file = 0;
        if ($("#attachment").val()) file = $("#attachment").val();
        if (file) {
            $("#attachment_label").html(file.slice(12));
        }
    });

    //Submit
    $('#main_submit_form').submit(function() {
        if (!$('#input_name').val() || !$('#input_mail').val()) {
            $('#warning_submit').css('display', 'block');
            return false
        }
        else {
            $('#details span.head').each(function() {
                if ($(this).children('input').attr('checked') !== 'checked') {
                    $(this).parent().find('input').each(function() {
                        $(this).val('');
                    });
                }
            });
        }
    });

    //Payment process
    $('img.header_click').click(function() {
        $(this).parent().find('div.payment_type_content').slideToggle('fast');
    });
    $('div.webmoney_div a,div.moneybookers_div a').attr('target', '_blank');
});