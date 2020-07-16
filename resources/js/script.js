const { default: Axios } = require("axios")

let detailModal = {
    el: document.getElementById('detail__modal'),

    show() {
        this.el.classList.remove('hidden')
    },
    close() {
        this.el.classList.add('hidden')
    }
}

detailModal.el.querySelectorAll('[id^=detail__]:not([id^=detail__email])').forEach(el => {
    const attrName = el.id.split('detail__')[1]
    Object.defineProperty(detailModal, attrName, {
        get: () => el.textContent,
        set: value => el.textContent = value
    })
})
detailModal.el.querySelectorAll('[id^=detail__email]').forEach(el => {
    const attrName = el.id.split('detail__')[1]
    Object.defineProperty(detailModal, attrName, {
        get: () => el.textContent,
        set: value => {
            el.href = `mailto:${value}`
            el.textContent = value
        }
    })
})

// let
//     detailModalEl = document.getElementById('detail__modal'),
//     detailModalBody = detailModalEl.querySelector('.modal__body')

// async function showProfileDetail($apiUrl) {
//     const
//         profileData = (await Axios.get($apiUrl)).data,
//         detailModal = new modal(detailModalEl)

//     detailModalBody.textContent = JSON.stringify(profileData)
//     detailModal.open()
// }

// window.detailModal = detailModal
// window.showProfileDetail = showProfileDetail
export default detailModal