import { Observable } from "@nativescript/core/data/observable";
import { Frame } from "tns-core-modules/ui/frame";
import * as app from "tns-core-modules/application";

export class BaseModel extends Observable {
  constructor(page) {
    super();
    // Initialize default values.
    this.page = page;
    this.topFrame = Frame.topmost();
    this.sideDrawer = app.getRootView();
    this.title = page && page.actionBarTitle;
  }

  goBack() {
    this.topFrame.goBack();
  }

  toggleSideDrawer() {
    this.sideDrawer.toggleDrawerState();
  }

  closeSideDrawer() {
    this.sideDrawer.closeModal();
  }

  toggleRightDrawer() {
    this.sideDrawer.getViewById("themeDrawer").toggleDrawerState();
  }

  openModal() {
    this.page.showModal("pages/modal-frame", {
      context: {
        title: "ActionBar in Modal",
      },
      closeCallback: () => {},
    });
  }
}
