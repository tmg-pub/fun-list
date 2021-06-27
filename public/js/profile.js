$(() => {
   $(".fun-item").each( function() {
      const e = $(this);
      HookTooltip( e );
   });
});