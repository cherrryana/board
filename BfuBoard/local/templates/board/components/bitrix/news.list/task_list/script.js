
document.addEventListener('DOMContentLoaded',function () {
    let formUpdate = document.getElementById('update_task')
    let formCreate = document.getElementById('create_task')
    let formNewBoard = document.getElementById('new_board')
    let formInviteUser = document.getElementById('invite')
     function customFormSubmit(form){
        let formData = new FormData(form);
        fetch(form.action, {
            method: 'POST',
            body: formData
        })
        setTimeout( function () {
                location.reload()
        },100)
    }


    formUpdate.addEventListener('submit',function(e){
        e.preventDefault()
        customFormSubmit(formUpdate)
    })
    formInviteUser.addEventListener('submit',function(e){
        e.preventDefault()
        customFormSubmit(formInviteUser)
    })
    formNewBoard.addEventListener('submit',function(e){
        console.log(Array.from(new FormData(formNewBoard)))
        e.preventDefault()
        customFormSubmit(formNewBoard)
    })
    formCreate.addEventListener('submit',function(e){
        e.preventDefault()
        customFormSubmit(formCreate)
    })




// Popups

    let newBoardToggles= document.querySelectorAll('.new-board-toggle');
    let newMemberToggles = document.querySelectorAll('.new-member-toggle');
    let popupContainer = document.querySelector('.popup-container');
    let popupNewBoard = document.querySelector('.popup--new-board');
    let popupNewMember = document.querySelector('.popup--new-member');
    let popupNewTask = document.querySelector('.popup--new-task');
    let popupTask = document.querySelector('.popup--task');

    newBoardToggles.forEach((toggle) => {
        toggle.addEventListener('click', () => {
            popupContainer.classList.toggle('popup-container--opened');
            popupNewBoard.classList.toggle('popup--opened');
        })
    })

    newMemberToggles.forEach((toggle) => {
        toggle.addEventListener('click', () => {
            popupContainer.classList.toggle('popup-container--opened');
            popupNewMember.classList.toggle('popup--opened');
        })
    })

// New task popup and open existing task
    let board = document.querySelector('.task-board');

    let closeButton = document.querySelector('.popup__close-toggle.task-toggle')
    closeButton.addEventListener('click',function () {
        popupContainer.classList.toggle('popup-container--opened');
        popupTask.classList.toggle('popup--opened');
    })
    let cards = document.querySelectorAll('.task-card');
    let createButtons = document.querySelectorAll('.new-task-toggle')
    for(let k = 0; k < cards.length; k++){
        cards[k].addEventListener('click', (evt) => {
            popupContainer.classList.toggle('popup-container--opened');
            popupTask.setAttribute('data-update-id',cards[k].getAttribute('data-item-id'))
            let currentName = cards[k].querySelector('.task-card__title').innerText;
            let currentDesc = cards[k].querySelector('.task-card__description').innerText;
            let currentDate = cards[k].querySelector('.task-card__date').innerText;
            let currentTags = cards[k].querySelectorAll('.task-card__theme');
            let inputName = formUpdate.querySelector("input[name='task-name']");
            let inputDesc = formUpdate.querySelector("textarea[name='task-description']");
            let inputDate = formUpdate.querySelector("input[name='task-date']");
            let inputTags = formUpdate.querySelectorAll("input[name*='task-theme']")
            let inputStatus = formUpdate.querySelector("select[name='task-status']")
            let inputId = formUpdate.querySelector("input[name='id']")
            console.log(inputId)
            for(let i = 0; i < currentTags.length; i++){
                for(let j = 0; j < inputTags.length; j++){
                    if(inputTags[j].value === currentTags[i].innerText){
                        inputTags[j].checked = true
                    }
                }
            }
            let currentStatus = parseInt(cards[k].getAttribute('data-status-id'));
            let optionsToStatus = inputStatus.querySelectorAll('option')
            let needleText = ''
            for(let i = 0; i < optionsToStatus.length; i++){
                if(optionsToStatus[i].value == currentStatus){
                    optionsToStatus[i].setAttribute('selected','')
                    needleText = optionsToStatus[i].innerText
                }else{
                    optionsToStatus[i].removeAttribute('selected')
                }
            }
            currentStatus.innerText = needleText
            inputName.value = currentName
            inputDesc.value = currentDesc
            inputDate.value = currentDate
            inputId.value = cards[k].getAttribute('data-item-id')
            popupTask.classList.toggle('popup--opened');
        })
    }
    for(let m = 0; m < createButtons.length; m++){
        createButtons[m].addEventListener('click',function (evt) {
            popupContainer.classList.toggle('popup-container--opened');
            popupNewTask.classList.toggle('popup--opened');

            let statusInput = formCreate.querySelector("select[name='task-status']")
            statusInput.value = createButtons[m].getAttribute('data-status-id')
            if (!evt.target.classList.contains('popup__close-toggle')) {
                let category = evt.target.parentNode.childNodes[1].textContent;
                let formSelect = document.querySelector('.new-task-select');
                formSelect.value = category;
            }
        })
    }


})



