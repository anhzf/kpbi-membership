type Subscriber<T = unknown> = (data: T) => void;

export class PubSub<T = unknown> {
  private subscribers: Subscriber<T>[] = [];

  constructor(
    private data: T,
  ) {
    //
  }

  get value() {
    return this.data;
  }

  publish(data: T) {
    this.data = data;

    this.subscribers.forEach((subscriber) => subscriber(data));
  }

  subscribe(callback: Subscriber<T>) {
    this.subscribers.push(callback);

    return () => this.unsubscribe(callback);
  }

  unsubscribe(callback: Subscriber<T>) {
    this.subscribers = this.subscribers.filter((subscriber) => subscriber !== callback);
  }

  unsubscribeAll() {
    this.subscribers = [];
  }
}
