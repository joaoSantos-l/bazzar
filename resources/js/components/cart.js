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
                await this.update(0);
            }
        },

        async update(newQty) {
            try {
                const res = await axios.post('/cart/update', {
                    product_id: productId,
                    quantity: newQty
                });

                this.qty = newQty > 0 ? newQty : 0;

                this.$dispatch('cart-updated', {
                    total_qty: res.data.cart_summary.total_qty,
                    total_price: res.data.cart_summary.total_price,
                    product_total: res.data.product_total,
                    product_id: productId
                });

            } catch (e) {
                console.error("Erro ao atualizar carrinho:", e);
            }
        }

    }
}
