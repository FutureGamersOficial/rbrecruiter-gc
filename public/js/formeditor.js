// reminder: use vuejs instead, this is still an ugly and cheap solution
$(document).ready(function(){

  var fieldID = 0;
  var wrapper = $('.field-container');
  var newBtn = $('#add');

  $(newBtn).click(function(e){
    e.preventDefault()
    fieldID++;

    $(wrapper).append('<div id=group' + fieldID + '><input type="text" name="newFieldID' + fieldID + '[]" class="form-control" />');
    $(wrapper).append('<select name="newFieldID' + fieldID + '[]" class="custom-select"> <option value="nil" disabled>Choose a type</option> <option value="textbox">Textbox</option> <option value="textarea">Multi line answer</option> <option value="checkbox">Checkbox</option> </select>');
    //$(wrapper).append('<button type="button" class="btn btn-danger btn-sm float-right delete"><i class="fas fa-minus"></i></button></div>');


  });

});
