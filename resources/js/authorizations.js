let user = window.App.user;

let authorizations = {
    // updateReply(reply) {
    //     return reply.user_id === user.id;
    // },
    // updateThread(thread) {
    //     return thread.user_id === user.id;
    // },
    owns(model, prop = "user_id"){
        return model[prop] === user.id;
    }
};

module.exports = authorizations;