const reportModal = document.getElementById('dashboard_report_modal');
const reportTable = document.querySelector('.dashboard_report_table');

if(reportModal){reportModal.addEventListener('click',() => {reportModal.style.display = "none"; })}


function ToggleReportModal(html, index) {
    
    reportModal.style.display = "flex";
    
    reportModal.innerHTML = html;
    
    // Récup des couleurs des stickers

window.setTimeout(recupColorsModal, 1050);

    
}


reportTable.querySelector('tbody').querySelectorAll('tr').forEach((ligne, index) => {
    
    ligne.querySelector('.dashboard_report_see').addEventListener('click', () => {
        ToggleReportModal(ligne.querySelector('.positit-template').outerHTML);
    })
    
    
})


