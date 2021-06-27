
let has_avatar = window.HasAvatar;
let avatar_changed = false;

let avatar_input_element = null;

/*
test = {
   "traits": {
      "name": "Imra Cinderlove",
      "slug": "imra",
      "race": "High-elf",
      "age": "Young Adult",
      "gender": "Girl",
      "color": "Purple", 
      "bestfriend": "Iolyn",
      "bedtime": "11pm central"
   },
   "bio": "Test bio field",
   "likes": {
      "fave": [
         { name: "Powerlifting" },
         { name: "foo", desc: "bar" }
      ],
      "yes": [
         { name: "Icies", desc: "Just love that shit!" },
         { name: "Snow" }
      ]
   }
}*/
//----------------------------------------------------------------------------------------
// Restrict character input for slug.
function RestrictSlugInputChars() {
   let slug = document.getElementById( "field_slug" )
   slug.addEventListener( "input", function(e) {
   slug.value = slug.value.replace( " ", "-" )
      .toLowerCase()
      .replace( /[^A-Za-z0-9-]/, "" );
   });
}

//----------------------------------------------------------------------------------------
function MakeFunDraggable( sel ) {
   sel.draggable( {
      appendTo: 'body',
      helper: "clone",
      revert: "invalid",
      revertDuration: 100,
      drag: function( event, ui ) {
         $(event.target).addClass( "pickedup" );
      },
      start: function( event, ui ) {
         $(this).draggable('instance').offset.click = {
            left: Math.floor( ui.helper.width() / 2 ),
            top: Math.floor( ui.helper.height() / 2 )
         };
         $(ui.helper).addClass( 'ui-draggable-helper' );
      },
      stop: function( event, ui ) {
         $(event.target).removeClass( "pickedup" );
      }
   });
}

//----------------------------------------------------------------------------------------
function LoadProfile() {
   const data = JSON.parse(atob(window.ProfileData));
   console.log(data);
   if( data.fields ) {
      if( data.fields.traits ) {
         for( const [key, value] of Object.entries(data.fields.traits) ) {
            console.log( key, value );
            let e = document.getElementById( "field_" + key.toLowerCase() );
            e.value = value;
         }
      }

      $("#bio").val( data.fields.bio ?? "" );

      if( data.fields.likes ) {
         for( const section of ['fave', 'yes', 'maybe', 'no'] ) {
            let jsection = $(`.likelist .${section}`);
            for( const like of (data.fields.likes[section] ?? []) ) {
               let elem = null;
               if( !like.desc ) {
                  // not custom
                  elem = $(`.fun[data-name="${like.name}"]`);
               } else {
                  elem = CreateCustomFun( like.name, like.desc );
               }
               jsection.append( elem );
            }
         }
      }
   }

   profile_id = data.id ?? null;
}

//----------------------------------------------------------------------------------------
function UpdateLists() {

}

//----------------------------------------------------------------------------------------
async function GetFuns() {
   let r = window.FunData;
   let funbox = $("#funbox");

   for( const fun of r ) {
      
      const item = $("<div class='fun'></div>")
                     .attr( "data-name", fun.name )
                     .text( fun.name )
      funbox.append( item );
      MakeFunDraggable( item );
      HookTooltip( item );
   }
   
   console.log( funPresetDescriptions );
}

//----------------------------------------------------------------------------------------
function RestorePreset( name ) {
   //$(`.fun[data-name={name}`).remove();

   //$(`.fun[data-name={name}`).remove();
}

//----------------------------------------------------------------------------------------
function SetupDroppables() {
   $(".fundrop").droppable({
      accept: ".fun",
      drop: function( ev, ui ) {
         $(ev.target).append( ui.draggable );
         //ui.draggable.remove();
         //ui.append("hi");
         $(ev.target).append($(ev.target).children(".fun").sort( function( a, b ) {
            if( a.dataset.name < b.dataset.name ) {
               return -1;
            } else if( a.dataset.name > b.dataset.name ) {
               return 1;
            } else {
               return 0;
            }
         }));
      }
   });
}

//----------------------------------------------------------------------------------------
function CreateCustomFun( name, desc ) {
   const item = $("<div class='fun'></div>")
                .attr( "data-name", name )
                .attr( "data-desc", desc )
                .text( name );
   MakeFunDraggable( item );
   HookTooltip( item );
   return item;
}

//----------------------------------------------------------------------------------------
function SetupCustomActivitiyWorkbench() {
   
   $(".add-custom-fun").on( "click", function() {
      const level = $(this).attr("data-level");
      const trait_name = $("#custom-fun").val().trim();
      const trait_desc = $("#custom-fun-desc").val().trim();
      if( trait_name == "" || trait_desc == "" ) return;
      $("#custom-fun").val("");
      $("#custom-fun-desc").val("");

      let item = CreateCustomFun( trait_name, trait_desc );
      $(`.likelist .${level}`).append( item );
   });
}

//----------------------------------------------------------------------------------------
function Publish() {

   Timer.Start( "publish", "ignore", 0, async function() {
      // Make payload.
      let no_errors = true;
      const payload = {};

      if( profile_id != "" ) {
         payload.profile = parseInt( profile_id );
      }

      payload.traits = {}
      $(".traitlist input.trait").each( function() {
         payload.traits[$(this).attr("name")] = $(this).val();
      });
      payload.bio = $("#bio").val();
      
      payload.likes = {
         fave: [],
         yes: [],
         maybe: [],
         no: []
      }
      $(".likelist .fundrop").each( function() {
         const e = $(this);
         
         const liketype = e.attr("data-liketype");
         e.children(".fun").each( function() {
            const f = $(this);
            const item = {};
            item.name = f.attr( "data-name" );
            if( f.attr("data-desc") ) {
               item.desc = f.attr( "data-desc" );
            }
            payload.likes[liketype].push( item );
         });
      });

      console.log( payload );
      const r = await (fetch( "/publish", {
         method: "POST",
         headers: {
            "Content-type": "application/json",
            "Accept": "application/json",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         body: JSON.stringify( payload )
      }).then( e => e.json() ));

      if( r.status == "okay" ) {
         profile_id = r.id;
         window.history.replaceState( null, "", `/edit/${profile_id}` );
         if( r.slug == 'in-use' ) {
            alert( "The profile URL is in use already. Choose another." );
            no_errors = false;
         } else {

            // Avatar upload
            if( profile_id && avatar_changed ) {
               if( !await UpdateAvatar() ) {
                  no_errors = false;
                  avatar_changed = false;
               }
            }
         }
      } else {
         alert( r.error );
         return;
      }

      if( payload.traits.slug == "" ) {
         alert( "No profile URL specified!" )
         no_errors = false;
      }

      if( no_errors ) {
         window.location = `/c/${payload.traits.slug}`;
      }
      console.log(r);
      console.log("exiting callback");
   });


}

//----------------------------------------------------------------------------------------
function CheckSlug() {
   let slug = $("#field_slug").val();
   if( slug == "" ) return;
   Timer.Start( "checkslug", "push", 0.5, async function() {
      let r = await ( fetch( `/api/checkslug/${slug}?profile=${profile_id}` )
                      .then(e => e.json()) );
      if( r.free ) {
         $("#slug-taken-error").hide()
      } else {
         $("#slug-taken-error").show()
      }
   });
}

//----------------------------------------------------------------------------------------
function UpdateAvatarButtons() {
   if( !has_avatar ) {
      $("#change_avatar").text( "Upload Picture" );
      $("#remove_avatar").hide();
   } else {
      $("#change_avatar").text( "Change Picture" );
      $("#remove_avatar").text( "Remove Picture" );
      $("#remove_avatar").show();
   }
   $("#change_avatar").show();
}

//----------------------------------------------------------------------------------------
async function UpdateAvatar() {

   if( !profile_id ) return false;

   console.log( avatar_input_element.files[0] );
   let formData = new FormData();
   if( avatar_input_element.files.length > 0 )
      formData.append( "picture", avatar_input_element.files[0], "picture" );
   
   let r = await (fetch( `/update_avatar/${profile_id}`, {
      method: "POST",
      body: formData,
      headers: {
         'Accept': "application/json",
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
   }).then( e => e.text() ));
   
   console.log( "Updated avatar", r );
   if( r.error ) {
      alert( r.error );
      return false;
   }
   return true;
}

//----------------------------------------------------------------------------------------
function SetupAvatarUpload() {
   avatar_input_element = document.createElement( "input" );
   avatar_input_element.type     = "file";
   avatar_input_element.multiple = false;
   avatar_input_element.accept   = "image/*";

   $("#change_avatar").on( "click", function() {
      avatar_input_element.click();
   });

   $("#remove_avatar").on( "click", function() {
      avatar_changed = true;
      has_avatar = false;
      document.getElementById("avatar_preview").src = "/avatar/none.jpg";
      avatar_input_element.value = "";
      UpdateAvatarButtons();
   });

   $(avatar_input_element).on("change", function() {
      avatar_changed = true;
      has_avatar = true;
      document.getElementById("avatar_preview").src = URL.createObjectURL( avatar_input_element.files[0] );
      UpdateAvatarButtons();
   });
}

//----------------------------------------------------------------------------------------
$(() => {
   UpdateAvatarButtons();
   RestrictSlugInputChars();
   GetFuns();
   LoadProfile();
   SetupDroppables();
   SetupAvatarUpload();
   SetupCustomActivitiyWorkbench();

   $("#button_publish").on( "click", Publish );

   $("<div id='slug-taken-error'></div>")
      .text( "That URL is already in use!" )
      .hide()
      .insertAfter( $("#field_slug") ); 
   $("#field_slug").on( "input", CheckSlug );

   console.log( "loaded edit.js" );
});
