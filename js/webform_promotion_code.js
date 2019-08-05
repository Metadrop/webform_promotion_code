(function ($, Drupal) {
  Drupal.behaviors.webform_promotion_code = {
    attach: function (context, settings) {
      
      function generateRandomCode(length) {
        var result           = '';
        var characters = $('input[name="properties[code_pattern]"]').val();
        if(!characters || characters === "") {
            characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        }
        var charactersLength = characters.length;
        for ( var i = 0; i < length; i++ ) {
           result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
      }
      
      function generateRandomCodes(amount) {
        var codeLength = $('input[name="properties[code_length]"]').val();
        if(!codeLength || codeLength === "") {
            codeLength = 6;
        }
        
        var newValue = $('textarea[name="properties[codes]"]').val();
        if(newValue !== "") {
          newValue = newValue.split("\n");
        } else {
          newValue = [];
        }
        for (var i = 0; i < amount; i++) {
          var randomCode = generateRandomCode(codeLength);
          newValue.push(randomCode);
        }
        
        $('textarea[name="properties[codes]"]').val(newValue.join("\n"));
      }
      
      $('span.wpc-auto-generate', context).once('webform_promotion_code').click(function(){
        var amount = $('input[name="properties[amount]"]').val();
        generateRandomCodes(amount);
      });
    }
  };
})(jQuery, Drupal);