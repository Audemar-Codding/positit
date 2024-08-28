
if(document.querySelector('.account-infos')) {

// style
const customColors = document.getElementById('custom-colors');
const customColorsBtn = document.querySelectorAll('.custom-colors-btn');
const maxStickerCounter = document.getElementById('maxsticker_counter');

// form
 const customForm = document.getElementById('custom-positit');
 const customTemplate = document.getElementById('positit-template');
 const customDivSticker = document.getElementById('sticker-div');
 const hiddenInputStickers = document.getElementById('hiddenInputSticker');
 const hiddenInputStyle = document.getElementById('hiddenInputStyle');

// icon-modal
 const customBtnIcon = document.getElementById('custom-btn-icon');
 const customModal = document.getElementById('custom-modal');
 const customModalIcons = document.getElementById('custom-modal-icons');
 const customModalAllIcons = document.querySelectorAll('.custom-icon + label');
 const customIconColorSelector = document.getElementById('custom-icon-color-selector');

// options
 const customBtnCancel = document.getElementById('custom-btn-cancel');
 const customBtnRotate = document.getElementById('custom-btn-rotate');
 const customBtnPlus = document.getElementById('custom-btn-plus');
 const customBtnMinus = document.getElementById('custom-btn-minus');



let iconSelected
// ==================== ICON  SELECTION 
if(customModalAllIcons[0] != undefined){
iconSelected = customModalAllIcons[0].getAttribute('data');
customModalIcons.querySelector('input:first-child').checked = true;

customBtnIcon.addEventListener('click', () => {customModal.style = "display:flex";})
customModal.addEventListener('click', () => {customModal.style = "display:none";})
customModalIcons.addEventListener('click', function(event) {event.stopPropagation();});

customModalAllIcons.forEach(icon => {

 icon.addEventListener('click', () => {
    iconSelected = icon.getAttribute('data');
 })
})

customIconColorSelector.addEventListener('blur', () => {
    customModalAllIcons.forEach( icon => {
    icon.querySelector('object').contentDocument.querySelector('svg').style.fill = customIconColorSelector.value;
    })
})
}

// ==================== CUSTOM
    
     customForm.addEventListener('submit', function() {
      hiddenInputStickers.value = customDivSticker.innerHTML;
    });
    
    // custom-colors
    const cls = ["positit-white", "positit-yellow", "positit-blue"];
    const btncls = ["custom-colors-white","custom-colors-yellow","custom-colors-blue"]
    const showColorSelected = () => {
     cls.forEach( (classColor, index) => {
       document.getElementById(btncls[index]).style = "border: 1px solid black";
     if(customTemplate.classList.contains(classColor)){
      document.getElementById(btncls[index]).style = "border: 2px solid var(--deepBlue)";  
     } })
    }
    showColorSelected();
    
    function CustomChangeColor(value) {

      if(value < 3 && value > -1)
      {
        customTemplate.classList.remove(...cls)
        customTemplate.classList.add(cls[value])
        hiddenInputStyle.value = cls[value];
        showColorSelected();
      }
    }
    // -------------
    
    // gestion max sticker
    let maxSticker = maxStickerCounter.innerText;
    maxSticker = Number(maxSticker);
    maxSticker -= customTemplate.querySelectorAll('.stickers').length;
    
    maxStickerCounter.innerText = maxSticker;
    
    // the options variables et récupération de la couleur
    let stickerSize = 100;
    let stickerRotation = 0;
    let cancelSticker = [];
    

    customTemplate.querySelectorAll('.stickers').forEach(sticker => {
        cancelSticker.push(sticker);
    });
    
recupColors();
    
    
    // add stickers
    customTemplate.addEventListener('click', function(event) {
       if(maxSticker>0) {
        
        let newDiv = document.createElement('div');
        newDiv.classList.add('stickers');
            
        // Calcul de la position de la souris par rapport au parent
            let rect = this.getBoundingClientRect();
            let x = event.clientX - rect.left;
            let y = event.clientY - rect.top;
        
        // Calcul de la position de la div en pourcentage du parent
            let leftPercent = (x / rect.width) * 100;
            let topPercent = (y / rect.height) * 100;
      
      // Positionnement de la nouvelle div
            newDiv.style.left = `calc(${leftPercent}% - ${5*stickerSize/100}%)`;
            newDiv.style.top = `calc(${topPercent}% - ${5*stickerSize/100}%)`;
            
        // création de l'objet à append
        let newObject = document.createElement('object');
        newObject.setAttribute('type',"image/svg+xml");
        newObject.setAttribute('data','Assets/pictures/icons/' + iconSelected); 
        newObject.style.width = stickerSize + '%';
        newObject.style.transform = `rotate(${stickerRotation}turn)`;

            
        newDiv.appendChild(newObject);
        customDivSticker.appendChild(newDiv);

        newObject.addEventListener('load', () => {
        newObject.contentDocument.querySelector('svg').style.fill = customIconColorSelector.value;
        newDiv.style.fill = customIconColorSelector.value;
        
        })
        
        cancelSticker.push(newDiv);
        
        maxSticker -= 1;
        maxStickerCounter.innerText = maxSticker;
       }

    })
  // -------------
   
  // cursor = sticker
    
  let cursorFollower;
  customTemplate.addEventListener('mouseover', () => {

// création du curseur custom
    cursorFollower = document.createElement('object');
    cursorFollower.setAttribute('type',"image/svg+xml");
    cursorFollower.setAttribute('data','Assets/pictures/icons/' + iconSelected); 
    cursorFollower.setAttribute('id','cursor-follower');
    cursorFollower.style.width = stickerSize/10 + '%';
    cursorFollower.style.transform = `rotate(${stickerRotation}turn)`;

    customTemplate.appendChild(cursorFollower);

    cursorFollower.addEventListener('load', () => {
    cursorFollower.contentDocument.querySelector('svg').style.fill = customIconColorSelector.value;
    })

         
        function onMouseMove(event) {
            const rect = customTemplate.getBoundingClientRect()
            cursorFollower.style.left = `calc(${event.clientX - rect.left}px - ${5*stickerSize/100}%)`; // Ajuster la position pour centrer le SVG
            cursorFollower.style.top = `calc(${event.clientY - rect.top}px - ${5*stickerSize/100}%)`;  // Ajuster la position pour centrer le SVG
          }

        customTemplate.addEventListener('mouseover', () => {
            document.addEventListener('mousemove', onMouseMove);
        });

        customTemplate.addEventListener('mouseout', () => {
            document.removeEventListener('mousemove', onMouseMove);
            cursorFollower.remove();
        });

  })
  // -------------
  
// ============================ OPTIONS

// cancel stickers
customBtnCancel.addEventListener('click', () => {
    if(cancelSticker.length != 0)
    {
        cancelSticker[cancelSticker.length-1].remove();
        cancelSticker.pop();
        maxSticker += 1;
        maxStickerCounter.innerText = maxSticker;
    }
})
//-------

// size gestion
customBtnPlus.addEventListener('click', () => ChangeSize(1));
customBtnMinus.addEventListener('click',() => ChangeSize(-1));


function ChangeSize(value) {
  
    if(stickerSize > 80 && value===-1) {
        stickerSize += -20;
    }else if(stickerSize < 120 && value===1) {
         stickerSize += 20;
    }
}
// -------

// rotate

customBtnRotate.addEventListener('click', () => {
    if(stickerRotation > -1) {
        stickerRotation -= 0.25;
    }else {stickerRotation = -0.25}
    
})
}

// =============================================================================================
    // ========================= GESTION MESSAGERIE ==============================================

const accountMessageIcon = document.querySelector('.account_messageicon');
const acountMessagesModal = document.querySelector('.acount_messages_modal');
const accountMessageTitle =  acountMessagesModal.querySelector('h2');
const accountMessagesList = acountMessagesModal.querySelector('ul');
const accountMessages = accountMessagesList.querySelectorAll('li');

accountMessageIcon.addEventListener('click', () => {
    acountMessagesModal.style.display = "block";
})


 acountMessagesModal.addEventListener('click', () => {
     acountMessagesModal.style.display = "none";
 })
    
 accountMessagesList.addEventListener('click', (event) => {
     event.stopPropagation();
 })
        

accountMessages.forEach((message) =>  {
    
    message.addEventListener('click', () => {
message.classList.add('fadeout');
let messageHide = accountMessagesList.querySelectorAll('li.fadeout');
accountMessageTitle.innerText = "Vous avez recu "+(accountMessages.length-messageHide.length)+' message'+((accountMessages.length-messageHide.length) > 1 ? 's' : ''); 

if(accountMessages.length-messageHide.length == 0){
    accountMessageIcon.style.display = "none";
}

    })
    
    
})