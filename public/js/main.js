function removeElement() {
    let extra_dates = document.querySelectorAll('td .extra_date_hidden');
    let parent_element_class = [];

    extra_dates.forEach((element) => {
        element.parentNode.parentNode.parentNode.classList.forEach((classs) => {
            if (classs !== 'filament-tables-cell') {
                parent_element_class.push(classs.replace('filament-table-cell-', ''));
            }
        })
    })
    parent_element_class.forEach(async (className) => {
        let parentElement = await document.querySelector(`.filament-table-header-cell-${className}`);
        if (parentElement) {
            parentElement.remove();
        }
    })
    extra_dates.forEach((element) => {
        element.parentNode.parentNode.parentNode.remove();
    })
}
removeElement();

const table_element = document.querySelector('.class-for-mutation-observer');
const observerOptions = {
    childList: true,
    attributes: true,
    subtree: true,
};

const observer = new MutationObserver(callback);
observer.observe(table_element, observerOptions);
function callback(mutationList, observer) {

    removeElement();
}