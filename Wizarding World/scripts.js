// Add magical particle effects on the landing page
const createMagicParticles = () => {
    const body = document.body;
    for (let i = 0; i < 50; i++) {
        const particle = document.createElement("div");
        particle.className = "particle";
        particle.style.top = Math.random() * 100 + "vh";
        particle.style.left = Math.random() * 100 + "vw";
        particle.style.animationDelay = Math.random() * 5 + "s";
        body.appendChild(particle);
    }
};

createMagicParticles();

// Show Notifications
const showNotification = (message, type) => {
    const notification = document.createElement("div");
    notification.className = `notification ${type}`;
    notification.innerText = message;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 3000);
};

// Trigger notifications for actions
document.addEventListener("DOMContentLoaded", () => {
    const successMessage = document.querySelector(".success")?.innerText;
    const errorMessage = document.querySelector(".error")?.innerText;

    if (successMessage) showNotification(successMessage, "success");
    if (errorMessage) showNotification(errorMessage, "error");
});
