var login = {
  /*
  * Method: init()
  * Description: initializes the login namespace
  * Usage: Called in App.js
  */
  init: function() {
    this.bindEvents();
    //will validate the login form
    //will validate the email reset form
  },

  /* 
  * Method: bindEvents()
  * Description: Function to bind all events for html elements
  * Usage: called when the login is initialized
  */
  bindEvents: function() {
    /*
    * Validate to make sure login and email is entered correctly
    */
    login.validateLogin();
    login.validateEmail();
    login.validatePassword();

  },

  /*
  * Method: validateLogin
  * Description: Function to check for blank fields
  * Usage: Called when the user clicks on the LoginSubmit button. Returns true if validate, else returns error.
  */
  validateLogin: function() {
    
    $("form[name='loginForm']").validate({ //use validation plugin
      rules: {
          account: {
            required: true,
            email: true
          },
          secure: {
            required: true
          }
      },
      submitHandler: function (form) { //return true if everything validates
        form.submit();
      },
      messages: { //messages to return if fields are empty
        account: {  
          required: "Can't leave email empty"
        },
        secure: {
          required: "Can't leave password empty"
        }
      }
    })

  },

  /*
  * Method: validateEmail
  * Description: Function to validate if an email is entered
  * Usage: Called when the user clicks on the Password Reset button. Returns true if validate, else returns error.
  */
  validateEmail: function() {

    $("form[name='passwordReset']").validate({ //use validation plugin
      rules: {
        account: {
          required: true,
          email: true
        }
      },
      submitHandler: function(form) { //return true if everything validates 
        form.submit();
      },
      messages: { //messages to return if field is not email or empty
        account: {
          required: "Can't leave email empty"
        }
      }
    })
  },


  /*
  * Method: validatePassword
  * Description: Function to validate a password change
  * Usage: Called when the user clicks on the Reset Password button. Returns true if validate, else returns error.
  */
  validatePassword: function() {
    
        $("form[name='newFormPassword']").validate({ //use validation plugin
          rules: {
            password: {
              required: true,
              minlength: 8
            },
            confirm: {
              required: true,
              equalTo: "#newPassword"
            }
          },
          submitHandler: function(form) { //return true if everything validates 
            form.submit();
          },
          messages: { //messages to return if field is not email or empty
            password: {
              required: "Can't leave password empty"
            },
            confirm: {
              equalTo: "Your confirmed password doesn't match"
            }
          }
        })
  }

}
