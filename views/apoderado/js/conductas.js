const btnActivate = (id) => {
    const btnActivate = document.querySelector(`#btn_${id}`);
    const containerActivate = document.querySelector(`.n__${id}`);
    const sectionNotes = document.querySelector(`.sec_${id}`);

    containerActivate.classList.toggle('activate');
    btnActivate.classList.toggle('activate_btn');
    sectionNotes.classList.toggle('sparcing');
}
