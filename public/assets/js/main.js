/**
 * আগামীর শৈলকুপা (Agamir Shailkupa) - Main Interactive Script
 * Handles Hero Slider, Mobile Responsive Drawer, Modals, Filter Tabs & Smooth Scroll
 */

const heroSlides = [
  {
    title: 'আগামীর শৈলকুপা',
    subtitle: 'শৈলকুপার উন্নয়ন, ঐতিহ্য ও মানুষের অগ্রযাত্রার একটি স্বেচ্ছাসেবী সামাজিক উদ্যোগ',
    primaryBtn: 'আমাদের সম্পর্কে জানুন',
    primaryTarget: '#about-section',
    secondaryBtn: 'ভিডিও দেখুন',
    badge: 'ঐতিহ্য ও উন্নয়ন'
  },
  {
    title: 'শিক্ষা ও মানবিক শৈলকুপা',
    subtitle: 'মেধাবী শিক্ষার্থীদের বৃত্তি প্রদান, ফ্রি মেডিকেল ক্যাম্প ও সামাজিক কল্যাণে আমরা অঙ্গীকারবদ্ধ',
    primaryBtn: 'চলমান কার্যক্রম দেখুন',
    primaryTarget: '#events-section',
    secondaryBtn: 'ভিডিও দেখুন',
    badge: 'সামাজিক কল্যাণ'
  },
  {
    title: 'সবুজ ও সমৃদ্ধ শৈলকুপা',
    subtitle: 'বৃক্ষরোপণ কর্মসূচি, টেকসই অবকাঠামো উন্নয়ন ও ঐতিহাসিক স্থান সংরক্ষণে সম্মিলিত প্রয়াস',
    primaryBtn: 'উন্নয়ন প্রকল্পসমূহ',
    primaryTarget: '#projects-section',
    secondaryBtn: 'ভিডিও দেখুন',
    badge: 'সবুজ শৈলকুপা'
  }
];

let currentSlideIndex = 0;
let heroInterval = null;

function renderHeroSlide(index) {
  const slide = heroSlides[index];
  const titleEl = document.getElementById('hero-title');
  const subtitleEl = document.getElementById('hero-subtitle');
  const primaryBtnText = document.getElementById('hero-primary-btn-text');
  const primaryBtnLink = document.getElementById('hero-primary-btn');
  const contentBox = document.getElementById('hero-content-box');

  // 1. Switch Carousel Background Images (Smooth Cross-fade & Ken Burns effect)
  const slideItems = document.querySelectorAll('.hero-slide-item');
  slideItems.forEach((item, idx) => {
    const img = item.querySelector('img');
    if (idx === index) {
      item.classList.remove('opacity-0', 'pointer-events-none', 'z-0');
      item.classList.add('opacity-100', 'z-10');
      if (img) {
        img.classList.remove('scale-100');
        img.classList.add('scale-105');
      }
    } else {
      item.classList.remove('opacity-100', 'z-10');
      item.classList.add('opacity-0', 'pointer-events-none', 'z-0');
      if (img) {
        img.classList.remove('scale-105');
        img.classList.add('scale-100');
      }
    }
  });

  // 2. Smooth Text & Button Transition
  if (contentBox) {
    contentBox.style.opacity = '0';
    contentBox.style.transform = 'translateY(6px)';
    setTimeout(() => {
      if (titleEl) titleEl.textContent = slide.title;
      if (subtitleEl) subtitleEl.textContent = slide.subtitle;
      if (primaryBtnText) primaryBtnText.textContent = slide.primaryBtn;
      if (primaryBtnLink) primaryBtnLink.setAttribute('href', slide.primaryTarget);
      contentBox.style.opacity = '1';
      contentBox.style.transform = 'translateY(0)';
    }, 220);
  }

  // 3. Update active indicator dots (Expanding Pill Indicator)
  const dots = document.querySelectorAll('.hero-dot');
  dots.forEach((dot, idx) => {
    if (idx === index) {
      dot.classList.remove('bg-white/80', 'w-2.5');
      dot.classList.add('bg-[#c8102e]', 'w-7');
    } else {
      dot.classList.remove('bg-[#c8102e]', 'w-7');
      dot.classList.add('bg-white/80', 'w-2.5');
    }
  });
}

function nextHeroSlide() {
  currentSlideIndex = (currentSlideIndex + 1) % heroSlides.length;
  renderHeroSlide(currentSlideIndex);
  resetHeroTimer();
}

function prevHeroSlide() {
  currentSlideIndex = (currentSlideIndex - 1 + heroSlides.length) % heroSlides.length;
  renderHeroSlide(currentSlideIndex);
  resetHeroTimer();
}

function goToHeroSlide(index) {
  currentSlideIndex = index;
  renderHeroSlide(currentSlideIndex);
  resetHeroTimer();
}

function resetHeroTimer() {
  if (heroInterval) clearInterval(heroInterval);
  // Auto scroll every 5 seconds (5000ms)
  heroInterval = setInterval(nextHeroSlide, 5000);
}

// Expose slider controls to window scope
window.nextHeroSlide = nextHeroSlide;
window.prevHeroSlide = prevHeroSlide;
window.goToHeroSlide = goToHeroSlide;

// Mobile Menu Toggle
function toggleMobileMenu() {
  const menu = document.getElementById('mobile-menu');
  const icon = document.getElementById('mobile-menu-icon');
  if (!menu) return;
  const isHidden = menu.classList.contains('hidden');
  if (isHidden) {
    menu.classList.remove('hidden');
    if (icon) {
      icon.classList.remove('ri-menu-3-line');
      icon.classList.add('ri-close-line');
    }
  } else {
    menu.classList.add('hidden');
    if (icon) {
      icon.classList.remove('ri-close-line');
      icon.classList.add('ri-menu-3-line');
    }
  }
}

function toggleMobileSubmenu() {
  const sub = document.getElementById('mobile-about-submenu');
  const arrow = document.getElementById('mobile-submenu-arrow');
  if (!sub) return;
  sub.classList.toggle('hidden');
  if (arrow) {
    arrow.classList.toggle('rotate-180');
  }
}

// User Dropdown Handlers (Desktop & Mobile)
function toggleDesktopUserDropdown(event) {
  if (event) event.stopPropagation();
  const dropdown = document.getElementById('desktop-user-dropdown-menu');
  if (!dropdown) return;
  dropdown.classList.toggle('hidden');
}

function toggleMobileUserDropdown() {
  const links = document.getElementById('mobile-user-dropdown-links');
  const arrow = document.getElementById('mobile-user-dropdown-arrow');
  if (!links) return;
  links.classList.toggle('hidden');
  if (arrow) {
    arrow.classList.toggle('rotate-180');
  }
}

// Close desktop dropdown on outside click
document.addEventListener('click', function(e) {
  const container = document.getElementById('desktop-user-dropdown-container');
  const dropdown = document.getElementById('desktop-user-dropdown-menu');
  if (container && dropdown && !container.contains(e.target)) {
    dropdown.classList.add('hidden');
  }
});

// Universal Modal Controller
function openInfoModal(title, category, dateOrMeta, description) {
  const modal = document.getElementById('info-modal');
  const modalTitle = document.getElementById('modal-title');
  const modalCat = document.getElementById('modal-category');
  const modalMeta = document.getElementById('modal-meta');
  const modalDesc = document.getElementById('modal-description');

  if (!modal) return;
  if (modalTitle) modalTitle.textContent = title;
  if (modalCat) modalCat.textContent = category;
  if (modalMeta) modalMeta.textContent = dateOrMeta;
  if (modalDesc) modalDesc.textContent = description;

  modal.classList.remove('hidden');
  modal.classList.add('flex');
}

function closeInfoModal() {
  const modal = document.getElementById('info-modal');
  if (!modal) return;
  modal.classList.add('hidden');
  modal.classList.remove('flex');
}

// Donation Modal Controller
function openDonateModal() {
  const modal = document.getElementById('donate-modal');
  if (!modal) return;
  modal.classList.remove('hidden');
  modal.classList.add('flex');
}

function closeDonateModal() {
  const modal = document.getElementById('donate-modal');
  if (!modal) return;
  modal.classList.add('hidden');
  modal.classList.remove('flex');
}

function selectDonateAmount(amount, btnEl) {
  const amountInput = document.getElementById('donate-amount-input');
  if (amountInput) amountInput.value = amount;
  document.querySelectorAll('.donate-preset-btn').forEach((btn) => {
    btn.classList.remove('bg-[#c8102e]', 'text-white', 'border-[#c8102e]');
    btn.classList.add('bg-gray-50', 'text-gray-700', 'border-gray-200');
  });
  if (btnEl) {
    btnEl.classList.remove('bg-gray-50', 'text-gray-700', 'border-gray-200');
    btnEl.classList.add('bg-[#c8102e]', 'text-white', 'border-[#c8102e]');
  }
}

function submitDonationForm(event) {
  if (event) event.preventDefault();
  const name = document.getElementById('donor-name')?.value || 'শুভানুধ্যায়ী সদস্য';
  const amount = document.getElementById('donate-amount-input')?.value || '১০০০';
  const method = document.getElementById('donate-method')?.value || 'bKash';
  const feedback = document.getElementById('donate-feedback');
  if (feedback) {
    feedback.textContent = `ধন্যবাদ ${name}! আপনার ৳${amount} (${method}) অনুদানের অনুরোধ সফলভাবে গৃহীত হয়েছে।`;
    feedback.classList.remove('hidden');
  }
  setTimeout(() => {
    if (feedback) feedback.classList.add('hidden');
    closeDonateModal();
  }, 2400);
}

// Video Modal Controller (Plays Live Video & Stops on Close)
function openVideoModal(videoUrl) {
  const modal = document.getElementById('video-modal');
  const iframe = document.getElementById('video-modal-iframe');
  if (!modal) return;

  if (iframe) {
    const srcToLoad = videoUrl || iframe.getAttribute('data-src') || 'https://www.youtube-nocookie.com/embed/hbcHJKGnXRk?autoplay=1&rel=0&modestbranding=1';
    iframe.setAttribute('src', srcToLoad);
  }

  modal.classList.remove('hidden');
  modal.classList.add('flex');
  document.body.classList.add('overflow-hidden');
}

function closeVideoModal() {
  const modal = document.getElementById('video-modal');
  const iframe = document.getElementById('video-modal-iframe');
  if (!modal) return;

  // Stop video playback immediately
  if (iframe) {
    iframe.setAttribute('src', '');
  }

  modal.classList.add('hidden');
  modal.classList.remove('flex');
  document.body.classList.remove('overflow-hidden');
}

// Make functions accessible globally
window.openVideoModal = openVideoModal;
window.closeVideoModal = closeVideoModal;

// Initialize Event Listeners
document.addEventListener('DOMContentLoaded', () => {
  resetHeroTimer();

  // Hero Carousel: Pause on hover & touch swipe support
  const heroSection = document.getElementById('hero-section');
  if (heroSection) {
    heroSection.addEventListener('mouseenter', () => {
      if (heroInterval) clearInterval(heroInterval);
    });
    heroSection.addEventListener('mouseleave', () => {
      resetHeroTimer();
    });

    let touchStartX = 0;
    let touchEndX = 0;
    heroSection.addEventListener('touchstart', (e) => {
      touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });
    heroSection.addEventListener('touchend', (e) => {
      touchEndX = e.changedTouches[0].screenX;
      if (touchStartX - touchEndX > 45) {
        nextHeroSlide(); // Swiped left -> next
      } else if (touchEndX - touchStartX > 45) {
        prevHeroSlide(); // Swiped right -> prev
      }
    }, { passive: true });
  }

  // Close mobile menu when clicking a navigation link
  document.querySelectorAll('.mobile-nav-link').forEach((link) => {
    link.addEventListener('click', () => {
      const menu = document.getElementById('mobile-menu');
      const icon = document.getElementById('mobile-menu-icon');
      if (menu && !menu.classList.contains('hidden')) {
        menu.classList.add('hidden');
        if (icon) {
          icon.classList.remove('ri-close-line');
          icon.classList.add('ri-menu-3-line');
        }
      }
    });
  });

  // Close modals on backdrop click
  ['info-modal', 'donate-modal', 'video-modal'].forEach((id) => {
    const el = document.getElementById(id);
    if (el) {
      el.addEventListener('click', (e) => {
        if (e.target === el) {
          if (id === 'video-modal') {
            closeVideoModal();
          } else if (id === 'donate-modal') {
            closeDonateModal();
          } else {
            closeInfoModal();
          }
        }
      });
    }
  });

  // Close modals on Escape key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      closeVideoModal();
      closeDonateModal();
      closeInfoModal();
    }
  });
});
