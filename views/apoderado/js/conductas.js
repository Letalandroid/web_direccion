const btnActivate = (id) => {
    const btnActivate = document.querySelector(`#btn_${id}`);
    const container_activate = document.querySelector(`.n__${id}`);
    const section_notes = document.querySelector(`.sec_${id}`);

    container_activate.classList.toggle('activate');
    btnActivate.classList.toggle('activate_btn');
    section_notes.classList.toggle('sparcing');
}
