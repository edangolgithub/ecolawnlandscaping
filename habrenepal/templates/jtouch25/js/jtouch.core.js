(function($){
	
/* Simple Namespace 
 * From: http://pietschsoft.com/post/2007/07/10/Creating-Namespaces-in-JavaScript-is-actually-rather-simple.aspx
 * */
if (typeof Namespace == 'undefined') var Namespace = {};
if (!Namespace.Manager) Namespace.Manager = {};
	
Namespace.Manager = {
	Register:function(namespace){
		namespace = namespace.split('.');
		if(!window[namespace[0]]) window[namespace[0]] = {};
		var strFullNamespace = namespace[0];
		for(var i = 1; i < namespace.length; i++){
			strFullNamespace += "." + namespace[i];
			eval("if(!window." + strFullNamespace + ")window." + strFullNamespace + "={};");
		}
 	}
};

/* Simple JavaScript Inheritance
 * By John Resig http://ejohn.org/
 * MIT Licensed.
 */
// Inspired by base2 and Prototype
(function(){
  var initializing = false, fnTest = /xyz/.test(function(){xyz;}) ? /\b_super\b/ : /.*/;
  // The base Class implementation (does nothing)
  this.Class = function(){};
  
  // Create a new Class that inherits from this class
  Class.extend = function(prop) {
    var _super = this.prototype;
    
    // Instantiate a base class (but only create the instance,
    // don't run the init constructor)
    initializing = true;
    var prototype = new this();
    initializing = false;
    
    // Copy the properties over onto the new prototype
    for (var name in prop) {
      // Check if we're overwriting an existing function
      prototype[name] = typeof prop[name] == "function" && 
        typeof _super[name] == "function" && fnTest.test(prop[name]) ?
        (function(name, fn){
          return function() {
            var tmp = this._super;
            
            // Add a new ._super() method that is the same method
            // but on the super-class
            this._super = _super[name];
            
            // The method only need to be bound temporarily, so we
            // remove it when we're done executing
            var ret = fn.apply(this, arguments);        
            this._super = tmp;
            
            return ret;
          };
        })(name, prop[name]) :
        prop[name];
    }
    
    // The dummy class constructor
    function Class() {
      // All construction is actually done in the init method
      if ( !initializing && this.init )
        this.init.apply(this, arguments);
    }
    
    // Populate our constructed prototype object
    Class.prototype = prototype;
    
    // Enforce the constructor to be what we expect
    Class.prototype.constructor = Class;

    // And make this class extendable
    Class.extend = arguments.callee;
    
    return Class;
  };
})();

/**
 * JTOUCH CORE NAMESPACE 
 */
Namespace.Manager.Register("Jtouch.Core");
Jtouch.Core.Object = Class.extend({
	options: new Object(),
	
	init: function(){
	},
	
	setOptions: function (options){
		$.extend(this.options, options);
	}
});
/**
 * JTOUCH UI NAMESPACE
 */
Namespace.Manager.Register("Jtouch.Ui");
/**
 * UI: ButtonTabs Controller
 */
Jtouch.Ui.ButtonTabs = Jtouch.Core.Object.extend({
	init: function (element, options){
		this.setOptions(options);
		this.mainElement = element;
		this.tabs = null;
		this.activeTab = null;
		
		// Draw tabs
		this.draw();
	},
	
	draw: function(){
		this.tabs = $(this.mainElement).find('div.jtouch-tab');
		if(this.tabs.length == 0) return;
		
		// Hide all tabs
		this.tabs.each(function(index){
			$(this).hide();
		});
		
		// Add onClick event for each button tab
		var thisCtl = this;
		$(this.mainElement + ' input.jtouch-button-tab').each(function(i){
			$(this).click(function(e){
				//e.preventDefault();
				// Hide current active tab
				if(thisCtl.activeTab != null) thisCtl.activeTab.hide();
				
				var activeId = $(this).val();
				thisCtl.activeTab = $(activeId);
				
				if(thisCtl.activeTab != null) thisCtl.activeTab.fadeIn('slow');
			});
		});
		
		// Active first tab
		$(this.mainElement + ' input.jtouch-button-tab:first').click();
	}
});

})(jQuery);


function jtouchValidateForm(f){
	//console.log('validate form..');
	if($(f).validate().form()){
		f.submit();
		return true;
	}
	return false;
}