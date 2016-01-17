$(document).ready(function() {
    $('form.form-signin').submit(function(){
        $('form.form-signin > button').removeClass('btn-success').addClass('btn-primary').attr('disabled','disabled').html('Loading...');
        var uname = $('input#username').val();
        var pword = $('input#password').val();
        gs.login(uname,pword);
        return false;
    });
    $('a.linkss').click(function(){
        alert("wew");
        return false;
    });
    //Add Instructor
    $('form.addInstructor').submit(function(){
        var username = $('form.addInstructor > div > input#username').val();
        var password = $('form.addInstructor > div > input#password').val();
        var fname = $('form.addInstructor > div > input#fname').val();
        var lname = $('form.addInstructor > div > input#lname').val();

        $('button.addInstructorButt').removeClass('btn-primary').addClass('btn-info').attr('disabled','disabled').html('Loading...');
        gs.addInstructor(username,password,fname,lname);
        return false;
    });
    //Add Student
    $('form.addStudent').submit(function(){
        var username = $('form.addStudent > div > input#username').val();
        var password = $('form.addStudent > div > input#password').val();
        var fname = $('form.addStudent > div > input#fname').val();
        var lname = $('form.addStudent > div > input#lname').val();
        var course = $('form.addStudent > div > select#course').val();

        $('button.addStudentButt').removeClass('btn-primary').addClass('btn-info').attr('disabled','disabled').html('Loading...');
        gs.addStudent(username,password,fname,lname,course);
        return false;
    });

    //Add Academic
    $('form.addAcademic').submit(function(){
        var subjectn = $('input#subjectn').val();
        var subjectc = $('input#subjectc').val();
        var prof = $('select#prof').val();

        $('button.addAcademicButt').removeClass('btn-primary').addClass('btn-info').attr('disabled','disabled').html('Loading...');
        gs.addAcademic(subjectn,subjectc,prof);
        return false;
    });

    //Edit Instructor
    $('form.editInstructor').submit(function(){
        var password = $('form.editInstructor > div > input#password').val();
        var fname = $('form.editInstructor > div > input#fname').val();
        var lname = $('form.editInstructor > div > input#lname').val();
        var id = $(this).attr('data-id');

        $('button.editInstructorButt').removeClass('btn-primary').addClass('btn-info').attr('disabled','disabled').html('Loading...');
        gs.editInstructor(fname,lname,password,id);
        return false;
    });

    //Edit Student
    $('form.editStudent').submit(function(){
        var password = $('form.editStudent > div > input#password').val();
        var fname = $('form.editStudent > div > input#fname').val();
        var lname = $('form.editStudent > div > input#lname').val();
        var course = $('form.editStudent > div > select#course').val();
        var id = $(this).attr('data-id');

        $('button.editStudentButt').removeClass('btn-primary').addClass('btn-info').attr('disabled','disabled').html('Loading...');
        gs.editStudent(fname,lname,password,id,course);
        return false;
    });
});
var gs = {
    login : function(uname,pword){
        $.ajax({
            type : 'POST',
            url : '/includes/functions.php?do=login',
            data : 'uname='+uname+'&pword='+pword,
            dataType : 'json',
            success : function(res){
                if(res.status==1){
                    $('form.form-signin > button').addClass('btn-success').removeClass('btn-primary').attr('disabled','false').html('Successfully logged in');
                    location.reload();
                }
                else {
                    $('form.form-signin > button').addClass('btn-danger').removeClass('btn-primary').attr('disabled','disabled').html('Invalid Username or Password');
                    $('input#username').val('').focus();
                    $('input#password').val('');
                    setTimeout(function(){
                        $('form.form-signin > button').addClass('btn-success').removeClass('btn-danger').prop('disabled',false).html('Sign in');
                    },2000);
                }
            }
        })
    },

    //Add Instructor Account
    addInstructor : function(username,password,fname,lname){
        $.ajax({
            type : 'POST',
            url : '/includes/functions.php?do=addInstructor',
            data : 'username='+username+'&password='+password+'&fname='+fname+'&lname='+lname,
            dataType : 'json',
            success : function(res){
                if(res.status==1){
                    $('button.addInstructorButt').removeClass('btn-info').addClass('btn-success').attr('disabled',false).html(res.text);
                    setTimeout(function(){
                        $('button.addInstructorButt').removeClass('btn-success').addClass('btn-primary').html('Add');
                        $('input#username').val('');
                        $('input#password').val('');
                        $('input#fname').val('');
                        $('input#lname').val('');
                        $('#addInstructor').modal('hide');
                    },3000);
                }
                else {
                    $('button.addInstructorButt').removeClass('btn-info').addClass('btn-danger').attr('disabled',false).html(res.text);
                    setTimeout(function(){
                        $('button.addInstructorButt').removeClass('btn-danger').addClass('btn-primary').html('Add');
                    },3000);
                }
            }
        })
    },

    //Add Student Account
    addStudent : function(username,password,fname,lname,course){
        $.ajax({
            type : 'POST',
            url : '/includes/functions.php?do=addStudent',
            data : 'username='+username+'&password='+password+'&fname='+fname+'&lname='+lname+'&course='+course,
            dataType : 'json',
            success : function(res){
                if(res.status==1){
                    $('button.addStudentButt').removeClass('btn-info').addClass('btn-success').attr('disabled',false).html(res.text);
                    setTimeout(function(){
                        $('button.addStudentButt').removeClass('btn-success').addClass('btn-primary').html('Add');
                        $('input#username').val('');
                        $('input#password').val('');
                        $('input#fname').val('');
                        $('input#lname').val('');
                        $('#addStudent').modal('hide');
                    },3000);
                }
                else {
                    $('button.addStudentButt').removeClass('btn-info').addClass('btn-danger').attr('disabled',false).html(res.text);
                    setTimeout(function(){
                        $('button.addStudentButt').removeClass('btn-danger').addClass('btn-primary').html('Add');
                    },3000);
                }
            }
        })
    },

    //Add Academic
    addAcademic : function(subjectn,subjectc,prof){
        $.ajax({
            type : 'POST',
            url : '/includes/functions.php?do=addAcademic',
            data : 'subjectn='+encodeURIComponent(subjectn)+'&subjectc='+subjectc+'&prof='+prof,
            dataType : 'json',
            success : function(res){
                if(res.status==1){
                    $('button.addAcademicButt').removeClass('btn-info').addClass('btn-success').attr('disabled',false).html(res.text);
                    setTimeout(function(){
                        $('button.addAcademicButt').removeClass('btn-success').addClass('btn-primary').html('Add');
                        $('input#subjectc').val('');
                        $('input#subjectn').val('');
                        $('#addAcademic').modal('hide');
                    },3000);
                }
                else {
                    $('button.addAcademicButt').removeClass('btn-info').addClass('btn-danger').attr('disabled',false).html(res.text);
                    setTimeout(function(){
                        $('button.addAcademicButt').removeClass('btn-danger').addClass('btn-primary').html('Add');
                    },3000);
                }
            }
        })
    },

    //Edit Instructor
    editInstructor : function(fname,lname,password,id){
        $.ajax({
            type : 'POST',
            url : '/includes/functions.php?do=editInstructor',
            data : 'fname='+fname+'&lname='+lname+'&password='+password+'&id='+id,
            dataType : 'json',
            success : function(res){
                if(res.status==1){
                    $('button.editInstructorButt').removeClass('btn-info').addClass('btn-success').attr('disabled',false).html(res.text);
                    setTimeout(function(){
                        location.href="/account.php?prof";
                    },3000);
                }
                else {
                    $('button.editInstructorButt').removeClass('btn-info').addClass('btn-danger').attr('disabled',false).html(res.text);
                    setTimeout(function(){
                        location.href="/account.php?prof";
                    },3000);
                }
            }
        })
    },

    //Edit Student
    editStudent : function(fname,lname,password,id,course){
        $.ajax({
            type : 'POST',
            url : '/includes/functions.php?do=editStudent',
            data : 'fname='+fname+'&lname='+lname+'&password='+password+'&id='+id+"&course="+course,
            dataType : 'json',
            success : function(res){
                if(res.status==1){
                    $('button.editStudentButt').removeClass('btn-info').addClass('btn-success').attr('disabled',false).html(res.text);
                    setTimeout(function(){
                        location.href="/account.php?student";
                    },3000);
                }
                else {
                    $('button.editStudentButt').removeClass('btn-info').addClass('btn-danger').attr('disabled',false).html(res.text);
                    setTimeout(function(){
                        location.href="/account.php?student";
                    },3000);
                }
            }
        })
    }
}