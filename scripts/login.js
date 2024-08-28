
const loginFormPasswordReset = document.getElementById('login_form_passwordreset');
const loginFormUserName = document.getElementById('userName');

const loginModal = document.getElementById('login_modal');
const loginModalForm = loginModal.querySelector('form');


if(loginModal) {
    
// click cadenas icon
    loginFormPasswordReset.addEventListener('click', () => {
           loginModal.style.display = "flex";
           loginModalForm.querySelector('#userNameHidden').value = loginFormUserName.value;
           
           
    })
    
// click modal    
    loginModal.addEventListener('click', () => {
           loginModal.style.display = "none";
    })
    
//
 loginModalForm.addEventListener('click', (event) => {
     event.stopPropagation();
 })
    
    
}