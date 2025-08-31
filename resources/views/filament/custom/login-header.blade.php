<style>
    .custom-login-header {
        text-align: center;
        margin-bottom: 2rem;
        position: relative;
        z-index: 10;
    }

    .custom-logo-container {
        position: relative;
        margin-bottom: 1.5rem;
        animation: logoFloat 3s ease-in-out infinite;
    }

    .custom-logo-icon {
        width: 5rem;
        height: 5rem;
        background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        box-shadow: 0 10px 30px rgba(139, 92, 246, 0.4);
        position: relative;
        overflow: hidden;
    }

    .custom-logo-icon::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transform: rotate(45deg);
        animation: shine 2s ease-in-out infinite;
    }

    .custom-logo-icon span {
        font-size: 2.5rem;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        z-index: 2;
        position: relative;
    }

    .custom-main-title {
        font-size: 3.5rem;
        font-weight: 900;
        background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 50%, #f97316 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.5rem;
        letter-spacing: 0.1em;
        text-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        animation: titleGlow 2s ease-in-out infinite alternate;
        font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
    }

    .custom-subtitle {
        font-size: 1.25rem;
        color: #6b7280;
        font-weight: 600;
        margin-bottom: 1rem;
        opacity: 0.9;
        font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
        position: relative;
    }

    .custom-subtitle::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, #8b5cf6, #ec4899);
        border-radius: 2px;
        animation: underlineExpand 2s ease-in-out infinite;
    }

    .custom-decoration {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        overflow: hidden;
    }

    .custom-decoration-dot {
        position: absolute;
        width: 6px;
        height: 6px;
        background: linear-gradient(135deg, #8b5cf6, #ec4899);
        border-radius: 50%;
        opacity: 0.6;
        animation: dotFloat 4s ease-in-out infinite;
    }

    .custom-decoration-dot:nth-child(1) {
        top: 20%;
        left: 15%;
        animation-delay: 0s;
    }

    .custom-decoration-dot:nth-child(2) {
        top: 60%;
        right: 20%;
        animation-delay: 1s;
    }

    .custom-decoration-dot:nth-child(3) {
        bottom: 30%;
        left: 25%;
        animation-delay: 2s;
    }

    .custom-decoration-dot:nth-child(4) {
        top: 40%;
        right: 35%;
        animation-delay: 3s;
    }

    @keyframes logoFloat {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-10px);
        }
    }

    @keyframes shine {
        0% {
            transform: translateX(-100%) rotate(45deg);
        }
        100% {
            transform: translateX(100%) rotate(45deg);
        }
    }

    @keyframes titleGlow {
        0% {
            filter: drop-shadow(0 4px 8px rgba(139, 92, 246, 0.3));
        }
        100% {
            filter: drop-shadow(0 6px 12px rgba(236, 72, 153, 0.4));
        }
    }

    @keyframes underlineExpand {
        0%, 100% {
            width: 60px;
        }
        50% {
            width: 100px;
        }
    }

    @keyframes dotFloat {
        0%, 100% {
            transform: translateY(0px) scale(1);
            opacity: 0.6;
        }
        50% {
            transform: translateY(-15px) scale(1.2);
            opacity: 1;
        }
    }

    @media (max-width: 768px) {
        .custom-main-title {
            font-size: 2.5rem;
        }

        .custom-logo-icon {
            width: 4rem;
            height: 4rem;
        }

        .custom-logo-icon span {
            font-size: 2rem;
        }

        .custom-subtitle {
            font-size: 1.1rem;
        }
    }
</style>

<div class="custom-login-header">
    <!-- Decorative Background Elements -->
    <div class="custom-decoration">
        <div class="custom-decoration-dot"></div>
        <div class="custom-decoration-dot"></div>
        <div class="custom-decoration-dot"></div>
        <div class="custom-decoration-dot"></div>
    </div>

    <!-- Logo Container -->
    <div class="custom-logo-container">
        <div class="custom-logo-icon">
            <span>🏰</span>
        </div>
    </div>

    <!-- Main Title -->
    <h1 class="custom-main-title">GOD's DOM PARK</h1>

    <!-- Subtitle -->
    <p class="custom-subtitle">A side of unique Query</p>
</div>
