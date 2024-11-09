import './bootstrap';
//id is the auth user and envent is the data sent to the pusher
if(role=='user'){
    window.Echo.private('App.Models.User.' + id)
    .notification((event) => {
        let link=showPostRoute.replace('slug',event.post_slug)
        $('#push-notifiactions').prepend(
            `
                 <div class="dropdown-item d-flex justify-content-between align-items-center">
                                         <span>Post comment :
                                            ${event.post_title.substring(0, 4)}....</span>
                                         <a href="${link}?notify=${event.id}">
                                             <li class="text-white   fa fa-eye"></li>
                                         </a>

                                     </div>
                `
        );

        count = Number($('#countNotificatios').text());
        console.log(count);
        count++
        $('#countNotificatios').text(count);
    });
}


if(role=='admin'){
    window.Echo.private('App.Models.Admin.' + adminId)
    .notification((event) => {
        $('#push-notifiactions-admin').prepend(
            `
                 <a class="dropdown-item d-flex align-items-center" href="${event.link}?notify_admin=${event.id}">
                        <div class="mr-3">
                            <div class="icon-circle bg-primary">
                                <i class="fas fa-file-alt text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">${event.date}</div>
                            <span class="font-weight-bold">${event.contact_title}</span>
                        </div>
                    </a>
                `
        );

        count = Number($('#countNotificationAdmin').text());
        count++
        $('#countNotificationAdmin').text(count);
    });
}

