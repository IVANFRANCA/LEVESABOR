/*jshint browser:true */
/*global $ */(function()
{
 "use strict";
 /*
   hook up event handlers 
 */    
 function register_event_handlers()
 {
    
    
     /* button  #voltar */
    $(document).on("click", "#voltar", function(evt)
    {
         /*global activate_page */
         activate_page("#pagina2"); 
    });
    
        /* button  #sairgeral */
    $(document).on("click", "#sairgeral", function(evt)
    {
         /*global activate_page */
         activate_page("#mainpage"); 
    });
    
    }
 document.addEventListener("app.Ready", register_event_handlers, false);
})();
