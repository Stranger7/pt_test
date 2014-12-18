/**
 * Created by Сергей on 18.12.2014.
 */
var Product = {
    modal: null,
    form: null,
    current_id: 0,

    entries: function() {
        $.ajax({
            url      : 'product/entries',
            type     : 'GET',
            dataType : 'html',
            success  : function(data) {
                $('#product-entries').html(data);
            },
            error    : function(data) {
                $("#errors").html(data.responseText);
            }
        });
    },

    create: function() {
        this.current_id = 0;
        this.modal.dialog('open');
    },

    load: function(id) {
        this.current_id = id;
        $.ajax({
            url      : 'product/entry',
            type     : 'POST',
            data     : Utils.jsonMerge({id: id}, Utils.securityToken()),
            dataType : 'json',
            success  : function(data) {
                $('#name').val(data.name);
                $('#description').val(data.description);
                $('#price').val(data.price);
                $('#quantity').val(data.quantity);
                Product.modal.dialog('open');
            },
            error    : function(data) {
                $("#errors").html(data.responseText);
            }
        });
    },

    save: function() {
        var params = 'id=' + this.current_id
            + '&' + $("#product-form").serialize()
            + '&' + Utils.securityTokenString();
        $.ajax({
            url      : 'product/save',
            type     : 'POST',
            dataType : 'json',
            data     : params,
            success  : function(data) {
                if (data.result == '1') {
                    Product.modal.dialog("close");
                    Product.entries();
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
    Product.form = document.getElementById('product-form');
    Product.modal = $('#dialog-form').dialog({
        autoOpen: false,
        height: 420,
        width: 400,
        modal: true,
        buttons: {
            "Сохранить": function() {
                Product.save();
            },
            "Cancel": function() {
                Product.modal.dialog("close");
            }
        },
        close: function() {
            $('#form-errors').html('');
            Product.form.reset();
        }
    });

    Product.entries();
});
