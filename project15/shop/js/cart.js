function addToCart(id){
 let cart=JSON.parse(localStorage.getItem('cart'))||[];
 let item=cart.find(i=>i.id==id);
 if(item)item.qty++; else cart.push({id:id,qty:1});
 localStorage.setItem('cart',JSON.stringify(cart));
 alert('Добавлено');
}
    function updateCartCount() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let count = cart.reduce((sum, item) => sum + item.quantity, 0);
        let cartCount = document.getElementById('cartCount');
        if(cartCount) cartCount.textContent = count;
    }
    
    function addToCart(id, name, price) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let existing = cart.find(item => item.id === id);
        
        if(existing) {
            existing.quantity++;
        } else {
            cart.push({ id: id, name: name, price: price, quantity: 1 });
        }
        
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartCount();
        
        let btn = event.target.closest('.add-to-cart');
        btn.innerHTML = '<i class="fas fa-check"></i> Добавлено!';
        setTimeout(() => {
            btn.innerHTML = '<i class="fas fa-shopping-cart"></i> В корзину';
        }, 1500);
        
        showNotification('Товар добавлен в корзину', 'success');
    }
    
    function showNotification(message, type) {
        let notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-info-circle'}"></i> ${message}`;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.classList.add('show');
        }, 100);
        
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
    
    updateCartCount();