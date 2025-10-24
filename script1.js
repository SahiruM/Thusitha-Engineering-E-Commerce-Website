
document.getElementById('contact-form')?.addEventListener('submit', (e) => {
    e.preventDefault();

    // Get form values
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;
    const messageText = document.getElementById('message').value;

    // Create the WhatsApp message
    let message = `*New Inquiry - Thusitha Engineering*\n\n` +
                  `*Name:* ${name}\n` +
                  `*Email:* ${email}\n` +
                  `*Phone:* ${phone}\n` +
                  `*Comment:* ${messageText}\n`;

    // WhatsApp phone number (replace with your number if needed)
    const phoneNumber = "94742925420";

    // Encode the message for URL
    const encodedMessage = encodeURIComponent(message);

    // Construct WhatsApp URL
    const whatsappURL = `https://wa.me/${phoneNumber}?text=${encodedMessage}`;

    // Open WhatsApp in a new tab/window
    window.open(whatsappURL, '_blank');

    // Show success message and reset form
    document.getElementById('form-message').textContent = 'Message sent! Redirecting to WhatsApp...';
    e.target.reset();
});

// Chat Functionality (Optional - Keeping it simple, no backend)
async function sendChat() {
    const input = document.getElementById('chat-input');
    const message = input.value.trim();
    if (message) {
        const chatBox = document.getElementById('chat-box');
        chatBox.innerHTML += `<p><strong>You:</strong> ${message}</p>`;
        chatBox.innerHTML += `<p><strong>Support:</strong> Thanks for your message! We'll get back to you soon.</p>`;
        input.value = '';
        chatBox.scrollTop = chatBox.scrollHeight;
    }
}

// Comments Functionality (Optional - Keeping it client-side)
function addComment() {
    const input = document.getElementById('comment-input');
    const comment = input.value.trim();
    if (comment) {
        const list = document.getElementById('comment-list');
        const li = document.createElement('li');
        li.innerHTML = `${comment} <button onclick="this.parentElement.remove()">Delete</button>`;
        list.appendChild(li);
        input.value = '';
    }
}

// Existing cart and product image popup code
let cart = [];
let cartCount = document.getElementById('cart-count');

function addToCart(name, price) {
    cart.push({ name, price });
    cartCount.textContent = cart.length;
    alert(`${name} added to cart!`);
}

const productImages = document.querySelectorAll('.product-image');
const popupOverlay = document.getElementById('popupOverlay');
const popupImage = document.getElementById('popupImage');

productImages.forEach(image => {
    image.addEventListener('mouseenter', () => {
        popupImage.src = image.src;
        popupOverlay.style.display = 'flex';
    });

    image.addEventListener('mouseleave', () => {
        popupOverlay.style.display = 'none';
    });
});