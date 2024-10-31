$(function() {
		var ticker = $("#ticker"); 
		ticker.children().filter("dt").each(function() { 		  
		  var dt = $(this),
		    container = $("<div>"); 		  
		  dt.next().appendTo(container);
      dt.prependTo(container);		  
		  container.appendTo(ticker);
		});			
		ticker.css("overflow", "hidden");	
		function animator(currentItem) {                                                		    
		  var distance = currentItem.height();
			duration = (distance + parseInt(currentItem.css("marginTop"))) / 0.025;       
		  currentItem.animate({ marginTop: -distance }, duration, "linear", function() {		    
			currentItem.appendTo(currentItem.parent()).css("marginTop", 0);
			animator(currentItem.parent().children(":first"));
		  }); 
		};		
		animator(ticker.children(":first"));				
		ticker.mouseenter(function() {
		ticker.children().stop(); 		  
		});	
		ticker.mouseleave(function() {
	  animator(ticker.children(":first"));
		});
});
