export const error = (el, binding) => {
    if(binding.value){
        el.classList.add('border')
        el.classList.add('border-red-500')
    }
    else {
        el.classList.remove('border')
        el.classList.remove('border-red-500')
    }
}
