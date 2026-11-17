document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.querySelector('.navbar');
    
    const handleNavbarScroll = function() {
        if (window.scrollY > 50) {
            navbar.classList.add('shadow-lg');
            navbar.style.padding = '0.5rem 0';
        } else {
            navbar.classList.remove('shadow-lg');
            navbar.style.padding = '0.75rem 0';
        }
    };
    
    window.addEventListener('scroll', handleNavbarScroll);
    handleNavbarScroll();
    
    const featureCards = document.querySelectorAll('.feature-card');
    featureCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transitionDelay = (index * 150) + 'ms';
        
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        
        observer.observe(card);
    });
    
    const stepCircles = document.querySelectorAll('.step-circle');
    stepCircles.forEach((circle, index) => {
        circle.style.opacity = '0';
        circle.style.transform = 'scale(0.8)';
        
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'scale(1)';
                    }, index * 100);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        
        observer.observe(circle);
    });
    
    const smoothScrollLinks = document.querySelectorAll('a[href^="#"]');
    smoothScrollLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                e.preventDefault();
                const navbarHeight = navbar.offsetHeight;
                const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - navbarHeight;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    const statCards = document.querySelectorAll('.stats-users, .stats-products, .stats-active, .stats-revenue');
    statCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transitionDelay = (index * 150) + 'ms';
        
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.2 });
        
        observer.observe(card);
    });
});