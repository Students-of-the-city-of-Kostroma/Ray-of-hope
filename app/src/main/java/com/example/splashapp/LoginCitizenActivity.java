package com.example.splashapp;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;

import com.example.splashapp.Dialogs.OkDialog;

import org.json.JSONObject;

import java.util.concurrent.ExecutionException;
import java.util.concurrent.TimeUnit;
import java.util.concurrent.TimeoutException;

public class LoginCitizenActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login_citizen);
    }

    public static String MyOrgId;

    public void LoginCitizen1(View view)
    {
        String[] input=new String[2];
        boolean Error = false;

        EditText edit = (EditText)findViewById(R.id.etemail);
        input[0] = edit.getText().toString();

        edit = (EditText)findViewById(R.id.etpas);
        input[1] = edit.getText().toString();

        CallDB_LoginCitizen RO=new CallDB_LoginCitizen();
        RO.execute(input);
        String Ret = "";

        try {
            Ret = RO.get(5, TimeUnit.SECONDS);

            boolean errors = Ret.contains("not_citizen_org");
            if (errors == true) {

                OkDialog okDialog = new OkDialog();
                okDialog.setMess("Пользователь не найден");
                okDialog.show(getFragmentManager(), "okDialog");
                Error = true;
            }

            errors = Ret.contains("empty");
            if (errors == true) {
                OkDialog okDialog = new OkDialog();
                okDialog.setMess("Заполните все поля");
                okDialog.show(getFragmentManager(), "okDialog");
                Error = true;
            }

            errors = Ret.contains("password_error");
            if (errors == true) {
                OkDialog okDialog = new OkDialog();
                okDialog.setMess("Неверный пароль");
                okDialog.show(getFragmentManager(), "okDialog");
                Error = true;
            }

            errors = Ret.contains("Error");
            if (errors == true) {
                OkDialog okDialog = new OkDialog();
                okDialog.setMess(Ret);
                okDialog.show(getFragmentManager(), "okDialog");
                Error = true;
            }

            if (Error == false) {

                Intent intent = new Intent(this, MyOrgProf.class);
                JSONObject json = new JSONObject(Ret);
                MyOrgId=json.get("id").toString();
                startActivity(intent);
                finish();
            }

        } catch (InterruptedException e) {
            e.printStackTrace();
        } catch (ExecutionException e) {
            e.printStackTrace();
        } catch (TimeoutException e) {
            e.printStackTrace();
        } catch (Exception e) {
            e.printStackTrace();
        }

    }

    public void LoginCitizen(View view)
    {
        String[] input=new String[2];
        boolean Error = false;

        EditText edit = (EditText)findViewById(R.id.etemail);
        input[0] = edit.getText().toString();

        edit = (EditText)findViewById(R.id.etpas);
        input[1] = edit.getText().toString();




//            if () {
//
//                OkDialog okDialog = new OkDialog();
//                okDialog.setMess("Пользователь не найден");
//                okDialog.show(getFragmentManager(), "okDialog");
//                Error = true;
//            }

            if (input[0].isEmpty()||input[1].isEmpty()) {
                OkDialog okDialog = new OkDialog();
                okDialog.setMess("Заполните все поля");
                okDialog.show(getFragmentManager(), "okDialog");
            }
            else {
                Intent intent = new Intent(this, CitProf.class);
                startActivity(intent);
                finish();
            }

    }

    public void CitizenRegisrt(View view)
    {
        Intent intent = new Intent(this, RegCitizen.class);
        startActivity(intent);
        finish();
    }
    public void ForgetPas(View view)
    {
        Intent intent = new Intent(this, PassworldRes.class);
        startActivity(intent);
        finish();
    }
}
