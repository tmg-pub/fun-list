
test = {
   "traits": {
      "name": "Imra Cinderlove",
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
         { name: "Icies", desc: "Just love that shit." },
         { name: "Snow" }
      ]
   }
}

function LoadProfile( data ) {
   for( const [key, value] of Object.entries(data.traits) ) {
      console.log( key, value );
      let e = document.getElementById( "field_" + key.toLowerCase() );
      e.value = value;
   }

   document.getElementById( "bio" ).innerText = data.bio;
}

console.log( "loaded edit.js" );
LoadProfile( test );

function UpdateLists() {

}