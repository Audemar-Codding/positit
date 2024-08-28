
const messageMinCounter = document.querySelector(".messageMinCounter");
const messageMaxCounter = document.querySelector(".messageMaxCounter");
const messageTextarea = document.querySelector(".posititMessage");
const messagePreview = document.querySelector(".positit-template-text");

const sendPosititBtn = document.getElementById('sendPositit_btn');
const moderationLoad = document.getElementById('moderation_load');

function updateCharacterCount() {
    
    
    let caractValue = 500 - messageTextarea.value.length; 
    
        messageMaxCounter.textContent =  caractValue;
    
    if (caractValue > 500) {
    messageTextarea.value = messageTextarea.value.substring(0, 500);
}
    
    if(caractValue > 490) {
                messageMinCounter.textContent = 10 -  messageTextarea.value.length; ;
    }else{messageMinCounter.textContent = ""}
    
    
    
    
            let value = messageTextarea.value;

    messagePreview.innerHTML= value.replace(/\n/g, '<br>');

    
    
    
}

// Récup des couleurs des stickers
recupColors();


sendPosititBtn.addEventListener('click', () => {
    if(messageTextarea.value.length > 0){
    moderationLoad.style.display = "flex";
    }
})

