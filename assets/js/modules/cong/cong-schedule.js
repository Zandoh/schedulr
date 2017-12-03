var cong_schedule = {
  /*
  * Method: init()
  * Description: initializes the congregation schedule namespace
  * Usage: Called in App.js
  */
  init: function() {
    this.bindEvents();
  
  },

  /* 
  * Method: bindEvents()
  * Description: Function to bind all events for html elements
  * Usage: Called when congregation schedule is initialized
  */
  bindEvents: function() {
    makeDraggable();
    function makeDraggable() {
        $(".sort-cong-name").draggable({
            helper: "clone",
            start: function(e) {
              placeholder = e.target;
              $(placeholder).addClass("opacity");
            },
            stop: function(e){
              $(placeholder).removeClass("opacity");
              placeholder = null;
            }  
            
        });
        $(".sort-cong-name").droppable({
            drop: function (e, ui) {
                $(placeholder).removeClass("opacity");
                placeholder = null;
                $(ui.draggable).clone().replaceAll(this);
                $(this).replaceAll(ui.draggable);
                makeDraggable();
            },
        });
    }
  }

}