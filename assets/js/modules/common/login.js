var login = {
  /*
  * Method: init()
  * Description: initializes the login namespace
  * Usage: Called in App.js
  */
  init: function() {
    this.bindEvents();
    //will validate the login processes
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
    login.validateLogin();
    

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

  }

}
