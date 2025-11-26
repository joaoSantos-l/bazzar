// resources/js/components/cart.js

import axios from "axios";

export default function cartComponent(productId, initialQuantity = 0) {
    return {
        qty: initialQuantity,

        inCart() {
            return this.qty > 0;
        },

        async increase() {
            await this.update(this.qty + 1);
        },

        async decrease() {
            if (this.qty > 1) {
                await this.update(this.qty - 1);
            } else {
                await this.update(0); // remove
            }
        },

        async update(newQty) {
            try {
                const res = await axios.post('/cart/update', {
                    product_id: productId,
                    quantity: newQty
                });

                if (newQty <= 0) {
                    this.qty = 0;
                } else {
                    this.qty = newQty;
                }

            } catch (e) {
                console.error("Erro ao atualizar carrinho:", e);
            }
        }
    }
}
