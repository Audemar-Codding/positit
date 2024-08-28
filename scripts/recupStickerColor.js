
//DOMContentLoaded

function recupColors() {
   window.addEventListener("load", function() {

let Templates = document.querySelectorAll('.sticker-div');
Templates.forEach( template => {
    template.querySelectorAll('.stickers').forEach(sticker => {
    let object = sticker.querySelector('object')
    object.contentDocument.querySelector('svg').style.fill = sticker.style.fill;
    });;
})

});

}


async function recupColorsModal() {
    
let Templates = document.querySelectorAll('.sticker-div');
Templates.forEach( template => {
    template.querySelectorAll('.stickers').forEach(sticker => {
    let object = sticker.querySelector('object');
    object.contentDocument.querySelector('svg').style.fill = sticker.style.fill;
    });;
})


}