import cash from "cash-dom";

(function (cash) {
  "use strict";

  // Show tab content
  cash("body").on("click", 'a[data-toggle="tab"]', function (key, el) {
    // Set active tab nav
    cash(this)
      .closest(".nav-tabs")
      .find('a[data-toggle="tab"]')
      .removeClass("active")
      .attr("aria-selected", false);
    cash(this).addClass("active").attr("aria-selected", true);

    // Set active tab content
    let elementId = cash(this).attr("data-target");
    let tabContentWidth = cash(elementId).closest(".tab-content").width();
    cash(elementId)
      .closest(".tab-content")
      .children(".tab-pane")
      .removeAttr("style")
      .removeClass("active");
    cash(elementId)
      .css("width", tabContentWidth + "px")
      .addClass("active");
  });
})(cash);
