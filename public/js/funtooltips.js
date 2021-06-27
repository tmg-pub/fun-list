
const funPresetDescriptions = {};

for( const fun of FunData ) {
    funPresetDescriptions[fun.name] = fun.desc;
}

//----------------------------------------------------------------------------------------
function Tooltip_OnEnter() {
    let e = $(this);
    let offset = e.offset();
 
    let funtip = $("#funtip");
    
    let name  = e.attr("data-name");
    let title = funtip.children(".title");
    let desc  = funtip.children(".desc");
    title.html( name );
 
    if( !e.attr("data-desc") ) {
       desc.text( funPresetDescriptions[name] );
       // Look up tooltip from preset data.
       // [name]
    } else {
       desc.text( e.attr("data-desc") );
    }
 
    funtip.show();
    funtip.offset({
       top: offset.top + e.outerHeight(),
       left: offset.left + e.outerWidth() / 2 - 100
    });
    //$(this).append( $(funtip) );
    ////$(funtip).insertAfter( $(this) );
    console.log( "foo" );
 }
 //---------------------------------------------------------------------------------------
 function Tooltip_OnLeave() {
    $("#funtip").hide();
 }

 //----------------------------------------------------------------------------------------
 function HookTooltip( sel ) {
    if( sel.data("tooltips") ) return;
    sel.data( "tooltips", true );
 
    sel.on( "mouseenter", Tooltip_OnEnter );
    sel.on( "mouseleave", Tooltip_OnLeave );
 }