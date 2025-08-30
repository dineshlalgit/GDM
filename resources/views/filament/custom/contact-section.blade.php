<style>
.contact-section {
    background: transparent;
    border-top: 2px solid rgba(59, 130, 246, 0.2);
    padding: 24px;
    margin: 0;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.contact-section.dark {
    background: transparent;
    border-top: 2px solid rgba(148, 163, 184, 0.2);
}

.contact-header {
    text-align: center;
    margin-bottom: 20px;
}

.contact-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
    border-radius: 50%;
    margin-bottom: 12px;
    box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
}

.contact-icon svg {
    width: 24px;
    height: 24px;
    color: white;
}

.help-text {
    font-size: 11px;
    color: #2563eb;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 8px;
}

.instruction-text {
    font-size: 13px;
    color: #374151;
    font-weight: 500;
    margin-bottom: 4px;
}

.contact-section.dark .help-text {
    color: #93c5fd;
}

.contact-section.dark .instruction-text {
    color: #d1d5db;
}

.admin-badge {
    display: inline-flex;
    align-items: center;
    padding: 8px 12px;
    background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%);
    color: white;
    font-size: 13px;
    font-weight: 700;
    border-radius: 9999px;
    box-shadow: 0 4px 15px rgba(139, 92, 246, 0.4);
    margin-bottom: 20px;
}

.admin-badge svg {
    width: 16px;
    height: 16px;
    margin-right: 8px;
}

.whatsapp-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 12px 24px;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    font-size: 13px;
    font-weight: 700;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
    text-decoration: none;
    transition: all 0.3s ease;
    margin-bottom: 20px;
}

.whatsapp-button:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    box-shadow: 0 12px 35px rgba(16, 185, 129, 0.4);
    transform: translateY(-2px) scale(1.02);
}

.whatsapp-button:active {
    transform: translateY(0) scale(0.98);
}

.whatsapp-button svg {
    width: 20px;
    height: 20px;
    margin-right: 8px;
    transition: transform 0.3s ease;
}

.whatsapp-button:hover svg {
    transform: scale(1.1);
}

.phone-badge {
    display: inline-flex;
    align-items: center;
    padding: 8px 12px;
    background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
    color: white;
    font-size: 11px;
    font-weight: 500;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    margin-bottom: 16px;
}

.phone-badge svg {
    width: 12px;
    height: 12px;
    margin-right: 8px;
}

.decorative-dots {
    display: flex;
    justify-content: center;
    gap: 4px;
}

.dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    animation: pulse 2s infinite;
}

.dot:nth-child(1) {
    background: linear-gradient(135deg, #60a5fa 0%, #8b5cf6 100%);
    animation-delay: 0s;
}

.dot:nth-child(2) {
    background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%);
    animation-delay: 0.4s;
}

.dot:nth-child(3) {
    background: linear-gradient(135deg, #ec4899 0%, #60a5fa 100%);
    animation-delay: 0.8s;
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
        transform: scale(1);
    }
    50% {
        opacity: 0.7;
        transform: scale(1.1);
    }
}
</style>

<div class="contact-section" id="contact-section">
    <div class="contact-header">
        <div class="contact-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
        </div>
        <div class="help-text">Need Help?</div>
        <div class="instruction-text">For any query contact admin</div>
    </div>

    <div style="text-align: center; margin-bottom: 20px;">
        <div class="admin-badge">
            <svg fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
            </svg>
            Uday Mondal
        </div>
    </div>

    <div style="text-align: center; margin-bottom: 20px;">
        <a href="https://wa.me/917063909875?text=Hi%20Uday,%20I%20have%20a%20query%20regarding%20the%20system."
           target="_blank"
           rel="noopener noreferrer"
           class="whatsapp-button">
            <svg fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
            </svg>
            Chat on WhatsApp
        </a>
    </div>

    <div style="text-align: center; margin-bottom: 16px;">
        <div class="phone-badge">
            <svg fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
            </svg>
            +91 70639 09875
        </div>
    </div>

    <div class="decorative-dots">
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
    </div>
</div>

<script>
// Auto-detect dark mode and apply appropriate styling
function updateTheme() {
    const contactSection = document.getElementById('contact-section');
    if (contactSection) {
        // Check if dark mode is active (you can adjust this logic based on your theme system)
        const isDark = document.documentElement.classList.contains('dark') ||
                      document.body.classList.contains('dark') ||
                      window.matchMedia('(prefers-color-scheme: dark)').matches;

        if (isDark) {
            contactSection.classList.add('dark');
        } else {
            contactSection.classList.remove('dark');
        }
    }
}

// Run on page load
document.addEventListener('DOMContentLoaded', updateTheme);

// Listen for theme changes
const observer = new MutationObserver(updateTheme);
observer.observe(document.documentElement, {
    attributes: true,
    attributeFilter: ['class']
});

// Also listen for system theme changes
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', updateTheme);
</script>
