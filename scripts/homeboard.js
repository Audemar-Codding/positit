const modalPositit = document.querySelector('.modal-positit');
const positits = document.querySelectorAll('.homeboard .positit-template:not(.homeboard_pinned_positit)');
const posititPinned = document.querySelector('.homeboard aside');


function ToggleModal(html,index) {
let posititid;
if(posititPinned) {
 posititid = posititPinned.querySelector('#pinned_posititid').value;

}else if(index != null) {  posititid = positits[index].querySelector('#posititid').value;}

modalPositit.innerHTML = html + '<a href="index.php?route=report&posititid='+posititid+'"target="_blank" class="report" id="report"><p>REPORT</p><i class="fa-solid fa-flag"></i></a>';
modalPositit.style.display = "flex";


if(index != null) {
  const likeModal =  modalPositit.querySelector("a.positit-template-like");

  if(likeModal){
    likeModal.addEventListener('click', () => {
    positits[index].querySelector(".positit-template-like").classList.add("positit-template-liked");
    })
  }
    

// gestion report     
modalPositit.querySelector('#report').addEventListener('click', () => {
positits[index].innerHTML = "<p class='positit-template-text'>Moderation en cours...</br>si ce posit'it vous a choqué ou blessé nous en somme sincérement désolé.</p>";
positits[index].style.border = "3px solid red";
positits[index].style.pointerEvents = "none";
positits[index].style.opacity = "0.45";
})    
    
}

if(posititPinned){
     modalPositit.querySelector('#report').addEventListener('click', () => {
     posititPinned.style.display = "none";

});
}

}


let i = 0;
let aleaPos = [[12,3],[48,3],[12,40],[48,40],[random(12, 48),random(3, 45)]];

positits.forEach((positit, index) => {
    positit.style.left = random(aleaPos[i][0], aleaPos[i][0]+20) + "%"; 
    positit.style.top = random(aleaPos[i][1], aleaPos[i][1]+20) + "%"; 
    i++;
    
     positit.addEventListener('click', () => {
       ToggleModal(positit.outerHTML,index);
     });
    
});


if(modalPositit){
modalPositit.addEventListener('click',() => {
   modalPositit.style.display = 'none';
    
})
}

if(posititPinned) {
   posititPinned.addEventListener('click', () => {

       ToggleModal(posititPinned.querySelector('.positit-template').outerHTML,null);
            modalPositit.querySelector('.positit-template').classList.remove('homeboard_pinned_positit');
      modalPositit.querySelector('.sticker-div').style.display = "block";
      window.setTimeout(recupColorsModal, 105);

     });
}

function random(min, max) {
    return Math.random() * (max - min) + min;
}







