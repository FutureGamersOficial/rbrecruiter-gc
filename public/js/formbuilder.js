$(document).ready(function() {
    $("#add").click(function() {
        var lastField = $("#buildyourform div:last");
        var intId = (lastField && lastField.length && lastField.data("idx") + 1) || 1;
        var fieldWrapper = $("<div class=\"fieldwrapper mb-5\" id=\"field" + intId + "\"/>");
        fieldWrapper.data("idx", intId);
        var fName = $("<input name=\"fieldID" + intId + "[]\" type=\"text\" class=\"fieldname form-control\" placeholder=\"Field name...\" />");
        var fType = $("<select name=\"fieldID" + intId + "[]\" class=\"fieldtype custom-select\"><option value=\"nil\" disabled>Field type</option></option><option value=\"checkbox\">Checkbox</option><option value=\"textbox\">Textbox</option><option value=\"textarea\">Multi-line answer</option></select>");
        var removeButton = $("<button type=\"button\" class=\"btn btn-sm btn-danger mt-3\"><i class=\"fa fa-minus\"></i></button>");
        removeButton.click(function() {
            $(this).parent().remove();
        });
        fieldWrapper.append(fName);
        fieldWrapper.append(fType);
        fieldWrapper.append(removeButton);
        $("#buildyourform").append(fieldWrapper);
    });
});

function save() {
    document.getElementById('formbuilder').submit();
}
