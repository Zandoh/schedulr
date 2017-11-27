var admin = {
  /*
  * Method: init()
  * Description: initializes the admin namespace
  * Usage: Called in App.js
  */
  init: function() {
    ajax.getUsers('returnAdminUsers');
    this.bindEvents();
  },

  /* 
  * Method: bindEvents()
  * Description: Function to bind all events for html elements
  * Usage: called when the login is initialized
  */
  bindEvents: function() {
    /*
    * Validate to make sure login is entered correctly
    */
    admin.validateLogin();

  },

  /*
  * Method: validateLogin
  * Description: Function to check for blank fields
  * Usage: Called when the user clicks on the Submit button. Returns true if validate, else returns error.
  */
  validateLogin: function() {
    
    $("form[name='addUserSubmit']").validate({ // use validation plugin
      rules: {
          email: {
            required: true,
            email: true
          },
          password: {
            required: true,
            minlength: 8,
            maxlength: 50
          },
          phoneNumber: {
            required: true,
            phoneUS: true
          },
          firstName: {
            required: true,
            maxlength: 200
          },
          lastName: {
            required: true,
            maxlength: 200
          }
      },
      submitHandler: function (form) { // return true if everything validates
        form.submit();
      }
    })

  }


}