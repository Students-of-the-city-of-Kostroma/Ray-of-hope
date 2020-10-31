package com.example.splashapp;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;

import com.example.splashapp.Dialogs.OkDialog;

public class PassworldRes extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_passworld_res);
    }

    public void ResetPas(View view)
    {

            OkDialog okDialog = new OkDialog();
            okDialog.setHead("");
            okDialog.setMess("Ваш пароль отправлен вам на почту");
            okDialog.show(getFragmentManager(), "okDialog");

        }
    public void ToLogin(View view)
    {
        if(Choice.citezen) {
            Intent intent = new Intent(this, LoginCitizenActivity.class);
            startActivity(intent);
            finish();
        }
        else {
            Intent intent = new Intent(this, LoginOrgActivity.class);
            startActivity(intent);
            finish();
        }


    }


}
