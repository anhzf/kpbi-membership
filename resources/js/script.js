let detailModal = {
  el: document.getElementById('detail__modal'),

  show() {
    this.el.classList.remove('hidden')
  },
  close() {
    this.el.classList.add('hidden')
  }
}

detailModal.el.querySelectorAll('[id^=detail__]:not([id^=detail__email]):not(#detail__web)').forEach(el => {
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

detailModal.el.querySelectorAll('#detail__web').forEach(el => {
  const attrName = el.id.split('detail__')[1]
  Object.defineProperty(detailModal, attrName, {
    get: () => el.textContent,
    set: value => el.textContent = el.href = value
  })
})

export default detailModal
