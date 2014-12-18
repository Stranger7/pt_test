/**
 * Created by Сергей on 18.12.2014.
 */
var Purchase = {
    modal: null,
    form: null,

    entries: function() {
        $.ajax({
            url      : 'purchase/entries',
            type     : 'GET',
            dataType : 'html',
            success  : function(data) {
                $('#purchase-entries').html(data);
            },
            error    : function(data) {
                $("#errors").html(data.responseText);
            }
        });
    },

    create: function() {
        this.modal.dialog('open');
    },

    save: function() {
        var params = $("#purchase-form").serialize() + '&' + Utils.securityTokenString();
        $.ajax({
            url      : 'purchase/save',
            type     : 'POST',
            dataType : 'json',
            data     : params,
            success  : function(data) {
                if (data.result == '1') {
                    Purchase.modal.dialog("close");
                    Purchase.entries();
                } else {
                    $("#form-errors").html(data.message);
                }
            },
            error    : function(data) {
                $("#form-errors").html(data.responseText);
            }
        });
    }
};

$(document).ready(function() {
    Purchase.form = document.getElementById('purchase-form');
    Purchase.modal = $('#dialog-form').dialog({
        autoOpen: false,
        height: 420,
        width: 400,
        modal: true,
        buttons: {
            "Сохранить": function() {
                Purchase.save();
            },
            "Cancel": function() {
                Purchase.modal.dialog("close");
            }
        },
        close: function() {
            $('#form-errors').html('');
            Purchase.form.reset();
        }
    });

    Purchase.entries();
});
