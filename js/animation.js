const sidebarLinks = document.querySelectorAll('.link-animation');
const sidebar = document.querySelector('.sidebar');

function handleScroll() {
  const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
  if (scrollTop > 0) {
    sidebar.classList.add('fixed');
  } else {
    sidebar.classList.remove('fixed');
  }

  sidebarLinks.forEach((link) => {
    if (link.classList.contains('active')) {
      link.classList.remove('active');
    }

    if (link.getAttribute('href') === `#${window.location.hash.slice(1)}`) {
      link.classList.add('active');
    }
  });
}

window.addEventListener('scroll', handleScroll);