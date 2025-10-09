<div class="modal-size-lg d-inline-block">
    <!-- Button trigger modal -->
    <!-- Modal -->
    <div class="modal fade text-start" id="services_modal" tabindex="-1" aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17">{{$modalTitle}}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form form-horizontal" id="servicesForm">
                        <input type="hidden" name="id_service" value="0" id="id_service">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label" for="title">Texto a Mostar en el Item</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="title" class="form-control" value="" name="title"
                                               placeholder="Home - Blog - Etc" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label" for="icon">Icono a Mostar en el Item</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select id="icon" style="width: 200px;">
                                            <option value="fa-globe" data-icon="fa-globe">Globe</option>
                                            <option value="fa-heart" data-icon="fa-heart">Heart</option>
                                            <option value="fa-car" data-icon="fa-car">Car</option>
                                            <option value="fa-user" data-icon="fa-user">User</option>
                                            <option value="fa-home" data-icon="fa-home">Home</option>
                                            <option value="fa-envelope" data-icon="fa-envelope">Envelope</option>
                                            <option value="fa-phone" data-icon="fa-phone">Phone</option>
                                            <option value="fa-bell" data-icon="fa-bell">Bell</option>
                                            <option value="fa-calendar" data-icon="fa-calendar">Calendar</option>
                                            <option value="fa-camera" data-icon="fa-camera">Camera</option>
                                            <option value="fa-clock" data-icon="fa-clock">Clock</option>
                                            <option value="fa-cloud" data-icon="fa-cloud">Cloud</option>
                                            <option value="fa-coffee" data-icon="fa-coffee">Coffee</option>
                                            <option value="fa-cog" data-icon="fa-cog">Cog</option>
                                            <option value="fa-comments" data-icon="fa-comments">Comments</option>
                                            <option value="fa-download" data-icon="fa-download">Download</option>
                                            <option value="fa-edit" data-icon="fa-edit">Edit</option>
                                            <option value="fa-eye" data-icon="fa-eye">Eye</option>
                                            <option value="fa-flag" data-icon="fa-flag">Flag</option>
                                            <option value="fa-folder" data-icon="fa-folder">Folder</option>
                                            <option value="fa-gift" data-icon="fa-gift">Gift</option>
                                            <option value="fa-heartbeat" data-icon="fa-heartbeat">Heartbeat</option>
                                            <option value="fa-image" data-icon="fa-image">Image</option>
                                            <option value="fa-key" data-icon="fa-key">Key</option>
                                            <option value="fa-lightbulb" data-icon="fa-lightbulb">Lightbulb</option>
                                            <option value="fa-link" data-icon="fa-link">Link</option>
                                            <option value="fa-lock" data-icon="fa-lock">Lock</option>
                                            <option value="fa-map" data-icon="fa-map">Map</option>
                                            <option value="fa-music" data-icon="fa-music">Music</option>
                                            <option value="fa-paperclip" data-icon="fa-paperclip">Paperclip</option>
                                            <option value="fa-paper-plane" data-icon="fa-paper-plane">Paper Plane</option>
                                            <option value="fa-pause" data-icon="fa-pause">Pause</option>
                                            <option value="fa-pencil-alt" data-icon="fa-pencil-alt">Pencil</option>
                                            <option value="fa-play" data-icon="fa-play">Play</option>
                                            <option value="fa-plug" data-icon="fa-plug">Plug</option>
                                            <option value="fa-plus" data-icon="fa-plus">Plus</option>
                                            <option value="fa-print" data-icon="fa-print">Print</option>
                                            <option value="fa-question" data-icon="fa-question">Question</option>
                                            <option value="fa-recycle" data-icon="fa-recycle">Recycle</option>
                                            <option value="fa-reply" data-icon="fa-reply">Reply</option>
                                            <option value="fa-save" data-icon="fa-save">Save</option>
                                            <option value="fa-search" data-icon="fa-search">Search</option>
                                            <option value="fa-share" data-icon="fa-share">Share</option>
                                            <option value="fa-shopping-cart" data-icon="fa-shopping-cart">Shopping Cart</option>
                                            <option value="fa-sign-in-alt" data-icon="fa-sign-in-alt">Sign In</option>
                                            <option value="fa-sign-out-alt" data-icon="fa-sign-out-alt">Sign Out</option>
                                            <option value="fa-sitemap" data-icon="fa-sitemap">Sitemap</option>
                                            <option value="fa-star" data-icon="fa-star">Star</option>
                                            <option value="fa-sync" data-icon="fa-sync">Sync</option>
                                            <option value="fa-tag" data-icon="fa-tag">Tag</option>
                                            <option value="fa-thumbs-up" data-icon="fa-thumbs-up">Thumbs Up</option>
                                            <option value="fa-thumbs-down" data-icon="fa-thumbs-down">Thumbs Down</option>
                                            <option value="fa-trash" data-icon="fa-trash">Trash</option>
                                            <option value="fa-trophy" data-icon="fa-trophy">Trophy</option>
                                            <option value="fa-truck" data-icon="fa-truck">Truck</option>
                                            <option value="fa-unlock" data-icon="fa-unlock">Unlock</option>
                                            <option value="fa-upload" data-icon="fa-upload">Upload</option>
                                            <option value="fa-user-plus" data-icon="fa-user-plus">User Plus</option>
                                            <option value="fa-user-minus" data-icon="fa-user-minus">User Minus</option>
                                            <option value="fa-video" data-icon="fa-video">Video</option>
                                            <option value="fa-volume-up" data-icon="fa-volume-up">Volume Up</option>
                                            <option value="fa-volume-down" data-icon="fa-volume-down">Volume Down</option>
                                            <option value="fa-volume-mute" data-icon="fa-volume-mute">Volume Mute</option>
                                            <option value="fa-wallet" data-icon="fa-wallet">Wallet</option>
                                            <option value="fa-wrench" data-icon="fa-wrench">Wrench</option>
                                            <option value="fa-battery-full" data-icon="fa-battery-full">Battery Full</option>
                                            <option value="fa-battery-half" data-icon="fa-battery-half">Battery Half</option>
                                            <option value="fa-battery-quarter" data-icon="fa-battery-quarter">Battery Quarter</option>
                                            <option value="fa-battery-empty" data-icon="fa-battery-empty">Battery Empty</option>
                                            <option value="fa-bluetooth" data-icon="fa-bluetooth">Bluetooth</option>
                                            <option value="fa-bolt" data-icon="fa-bolt">Bolt</option>
                                            <option value="fa-book" data-icon="fa-book">Book</option>
                                            <option value="fa-briefcase" data-icon="fa-briefcase">Briefcase</option>
                                            <option value="fa-building" data-icon="fa-building">Building</option>
                                            <option value="fa-bus" data-icon="fa-bus">Bus</option>
                                            <option value="fa-calculator" data-icon="fa-calculator">Calculator</option>
                                            <option value="fa-chess" data-icon="fa-chess">Chess</option>
                                            <option value="fa-code" data-icon="fa-code">Code</option>
                                            <option value="fa-credit-card" data-icon="fa-credit-card">Credit Card</option>
                                            <option value="fa-database" data-icon="fa-database">Database</option>
                                            <option value="fa-desktop" data-icon="fa-desktop">Desktop</option>
                                            <option value="fa-dollar-sign" data-icon="fa-dollar-sign">Dollar Sign</option>
                                            <option value="fa-dove" data-icon="fa-dove">Dove</option>
                                            <option value="fa-dumbbell" data-icon="fa-dumbbell">Dumbbell</option>
                                            <option value="fa-fax" data-icon="fa-fax">Fax</option>
                                            <option value="fa-film" data-icon="fa-film">Film</option>
                                            <option value="fa-fire" data-icon="fa-fire">Fire</option>
                                            <option value="fa-first-aid" data-icon="fa-first-aid">First Aid</option>
                                            <option value="fa-futbol" data-icon="fa-futbol">Futbol</option>
                                            <option value="fa-gavel" data-icon="fa-gavel">Gavel</option>
                                            <option value="fa-glass-martini" data-icon="fa-glass-martini">Glass Martini</option>
                                            <option value="fa-graduation-cap" data-icon="fa-graduation-cap">Graduation Cap</option>
                                            <option value="fa-hammer" data-icon="fa-hammer">Hammer</option>
                                            <option value="fa-hdd" data-icon="fa-hdd">HDD</option>
                                            <option value="fa-headphones" data-icon="fa-headphones">Headphones</option>
                                            <option value="fa-helicopter" data-icon="fa-helicopter">Helicopter</option>
                                            <option value="fa-highlighter" data-icon="fa-highlighter">Highlighter</option>
                                            <option value="fa-hotel" data-icon="fa-hotel">Hotel</option>
                                            <option value="fa-hourglass" data-icon="fa-hourglass">Hourglass</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label" for="description">Texto a Mostar en el Item</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="description" class="form-control" value="" name="description"
                                               placeholder="Home - Blog - Etc" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="saveService" class="btn btn-primary" data-bs-dismiss="modal">Procesar</button>
                </div>
            </div>
        </div>
    </div>
</div>
