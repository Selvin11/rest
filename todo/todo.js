// 小程序模拟接口
const URL = 'http://localhost:8888/rest/api/list'

let pageParams = {
    data: {
        todos: []
    }
}

pageParams.onLoad = function() {
    const that = this
    wx.request({
        url: URL,
        data: JSON.stringify({}),
        header: {
            'Accept': 'application/json'
        },
        method: 'GET',
        success: res => {
            // console.log(res.data)
            that.setData({
                todos: res.data
            })
            console.log(that.data.todos)
        },
        fail: () => console.error('something is wrong'),
        // complete: () => console.log('get req completed')
    })
}

pageParams.toggleTodo = function(event) {
    const that = this
    const selectedTodo = event.target.dataset.todo
    console.log(selectedTodo)
    const url = `${URL}/${selectedTodo.id}`
    const updatedTodo = Object.assign({}, selectedTodo, {
        complete: selectedTodo.complete ? 0 : 1
    }, {})
    console.log(updatedTodo)
    wx.request({
        url: url,
        data: JSON.stringify(updatedTodo),
        header: {
            'Accept': 'application/json'
        },
        method: 'PUT',
        success: res => {
            // console.log(res.data)
            that.setData({
                todos: that.data.todos.map(todo => {
                    if (todo.id === updatedTodo.id) {
                        return updatedTodo
                    }
                    return todo
                })
            })
        },
        fail: () => console.error('something is wrong'),
        // complete: () => console.log('toggle req completed')
    })
}

pageParams.removeTodo = function(event) {
    const that = this
    const selectedTodo = event.target.dataset.todo
    const url = `${URL}/${selectedTodo.id}`;

    wx.request({
        url: url,
        data: JSON.stringify(selectedTodo),
        header: {
            'Accept': 'application/json'
        },
        method: 'DELETE',
        success: res => {
            console.log(res.data)
            that.setData({
                todos: that.data.todos.filter(todo => todo.id !== selectedTodo.id)
            })
        },
        fail: () => console.error('something is wrong'),
        complete: () => console.log('delete req completed')
    })
}

Page(pageParams)