export class EventEmitter<T> {
  listeners: ((event: T) => void)[] = [];

  subscribe(callback: (event: T) => void) {
    this.listeners.push(callback);
    return () => {
      let idx = this.listeners.indexOf(callback);
      if (idx >= 0) this.listeners.splice(idx, 1);
    };
  }

  fire(event: T) {
    for (var cb of this.listeners) {
      try {
        cb(event);
      } catch {
        //ignore
      }
    }
  }
}
