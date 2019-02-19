const container = document.querySelector('.answers');
const titles = container.querySelectorAll('.answers__item-title');
for (const title of titles) {
  title.addEventListener('click', onClickTab);
}

function onClickTab(event) {
  const title = event.currentTarget;
  const tab = title.nextElementSibling;
  if (tab.classList.contains('answers__item-tab-active')) {
    tab.classList.remove('answers__item-tab-active');
    return;
  }
  const tabs = container.querySelectorAll('.answers__item-tab');
  for(const tab of tabs) {
    tab.classList.remove('answers__item-tab-active');
  }
  tab.classList.add('answers__item-tab-active');
}

