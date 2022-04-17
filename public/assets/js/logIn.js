const url = 'http://localhost/shopv2/api/user/userLogIn';
const LogIn = () => {

    const [formErrors, setFormErrors] = React.useState({});
    const [userName, setUserName] = React.useState(null);
    const [password, setPassword] = React.useState(null);
    const [show, setShow] = React.useState(false);

    //form validation handler
    const validate = (userName, password) => {
        let errors = {};
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/i;

        if (!userName) {
            errors.userName = "این فیلد اجباری است";
        } else if (!regex.test(userName)) {
            errors.userName = "فرمت ایمیل صحیح نمی باشد";
        }

        if (!password) {
            errors.password = "این فیلد اجباری است";
        } else if (password.length < 4) {
            errors.password = "رمز عبور باید بیشتر از 4 کارکتر باشد";
        }

        return errors;
    };

    const handelSubmit = async () => {
        let validation = validate(userName, password);
        setFormErrors(validation);
        if (Object.keys(validation).length === 0) {
            let data = {
                username: userName,
                password: password,
            }
            console.log(data);
            try {
                const response = await axios.post(url, JSON.stringify(data), {
                    headers: {
                        "Content-Type": "application/json",
                    }
                });
                console.log(response);
                if (response.data.statusText === "ok") {
                    window.location.href = response.data.url;
                } else {
                    setShow(true);
                }
            } catch (error) {
                console.error(error);
            }
        }

    }

    return (
        <div className="row">
            <div className="col-12 col-sm-10 offset-sm-1">
                <div className="content">
                    <div className="row">
                        <div className="col-12 col-lg-5 text-center">
                            <img src="assets/images/login.png" alt="" />
                        </div>
                        <div className="col-12 col-lg-7 pt-5 pt-md-0 align-self-center">
                            <div className="title">وارد شوید</div>
                            <p>با عضویت در سایت از همه امکانات سایت بهره مند شوید.</p>
                            <div className="form-group">
                                <label htmlFor="email">پست الکترونیک :</label>
                                <input type="email" className="form-control" onChange={(e) => {
                                    setUserName(e.target.value);
                                    setFormErrors({});
                                    setShow(false);
                                }} />
                                {formErrors.userName && (
                                    <span className="error">{formErrors.userName}</span>
                                )}
                            </div>
                            <div className="form-group">
                                <label htmlFor="password">رمز عبور :</label>
                                <input type="password" style={{textAlign:"left", direction:"ltr"}} className="form-control" onChange={(e) => {
                                    setPassword(e.target.value);
                                    setFormErrors({});
                                    setShow(false);
                                }} />
                                {formErrors.password && (
                                    <span className="error">{formErrors.password}</span>
                                )}
                            </div>
                            {show &&
                                <div className="alert alert-danger" role="alert" style={{ textAlign: "center" }}>
                                    نام کاربری یا رمز عبور اشتباه است
                                </div>
                            }
                            <div className="form-group">
                                <input type="submit" value="ورود به ناحیه کاربری" className="btn btn-success" onClick={handelSubmit} />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
ReactDOM.render(<LogIn />, document.querySelector('#logIn_container'));
