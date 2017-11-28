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
    * Validate to make sure users are added and edited appropriately
    */
    admin.validateAddUser();
    admin.validateEditUser();

    /*
    * Validate to make sure congregations are added and edited appropriately
    */
    admin.validateEditCong();
    admin.validateAddCong();
  },

  /*
  * Method: validateAddUser
  * Description: Function to check for blank fields
  * Usage: Called when the user clicks on the Submit button for adding Users. Returns true if validate, else returns error.
  */
  validateAddUser: function() {
    
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

  },

  /*
  * Method: validateEditUser
  * Description: Function to check for blank fields in the edit user functionality
  * Usage: Called when the user clicks on the edit user Submit button. Returns true if validate, else returns error.
  */
  validateEditUser: function() {
    
    $("form[name='editUserSubmit']").validate({ // use validation plugin
      rules: {
          email: {
            required: true,
            email: true
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

  },

  /*
  * Method: validateEditCong
  * Description: Function to check for blank fields
  * Usage: Called when the user clicks on the Submit button for editing congregations. Returns true if validate, else returns error.
  */
  validateEditCong: function() {
    
    $("form[name='editCongSubmit']").validate({ // use validation plugin
      rules: {
          congregation_name: {
            required: true,
            maxlength: 200
          },
          congregation_phone: {
            required: true,
            phoneUS: true
          },
          congregation_street_address: {
            required: true,
            maxlength: 200
          },
          congregation_city: {
            required: true,
            maxlength: 200
          },
          congregation_state: {
            required: true,
            minlength: 2,
            maxlength: 2,
            lettersonly: true
          },
          congregation_zip: {
            required: true,
            minlength: 5,
            maxlength: 5,
            number: true
          }
      },
      submitHandler: function (form) { // return true if everything validates
        form.submit();
      }
    })

  },

  /*
  * Method: validateAddCong
  * Description: Function to check for blank fields
  * Usage: Called when the user clicks on the Submit button for adding congregations. Returns true if validate, else returns error.
  */
  validateAddCong: function() {
    
    $("form[name='addCongSubmit']").validate({ // use validation plugin
      rules: {
          congregation_name: {
            required: true,
            maxlength: 200
          },
          congregation_phone: {
            required: true,
            phoneUS: true
          },
          congregation_street_address: {
            required: true,
            maxlength: 200
          },
          congregation_city: {
            required: true,
            maxlength: 200
          },
          congregation_state: {
            required: true,
            minlength: 2,
            maxlength: 2,
            lettersonly: true
          },
          congregation_zip: {
            required: true,
            minlength: 5,
            maxlength: 5,
            number: true
          }
      },
      submitHandler: function (form) { // return true if everything validates
        form.submit();
      }
    })

  }


}