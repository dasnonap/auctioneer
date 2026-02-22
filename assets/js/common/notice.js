document.addEventListener('DOMContentLoaded', initNotifications)

function initNotifications() {
    const notices = document.querySelectorAll('.js-notice')

    notices.forEach(notice => {
        const closeBtn = notice.querySelector('.js-notice-close')

        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                dismissNotice(notice)
            })
        }
    })
}

function dismissNotice(notice) {
    notice.classList.remove('visible')
    
    // Listen for animation/transition end and remove element
    const handleAnimationEnd = () => {
        notice.removeEventListener('animationend', handleAnimationEnd)
        notice.removeEventListener('transitionend', handleAnimationEnd)
        notice.remove()
    }
    
    notice.addEventListener('animationend', handleAnimationEnd)
    notice.addEventListener('transitionend', handleAnimationEnd)
}