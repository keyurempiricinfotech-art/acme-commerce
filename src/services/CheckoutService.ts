import { PaymentRepository } from "../payments/PaymentRepository";

export class CheckoutService {
  constructor(private readonly paymentRepository: PaymentRepository) {}

  async paymentMethods(userId: number) {
    return this.paymentRepository.findPaymentMethods(userId);
  }
}
