package com.example.splashapp;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import com.example.splashapp.Dialogs.OkDialog;
import android.view.View;

public class Choice extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.choice);

    }
    public static boolean citezen=true;

        public void CitChoice(View view)
        {
            //citezen=true;
            //Perehod();
            citezen=true;
            //Perehod();
            Intent intent = new Intent(this, LoginCitizenActivity.class);
            startActivity(intent);
            finish();
        }
        public void OrgChoice(View view)
        {
            citezen=false;
            //Perehod();
            Intent intent = new Intent(this, LoginOrgActivity.class);
            startActivity(intent);
            finish();
        }

    public  void Perehod()
    {
        Intent intent = new Intent(this, AboutView.class);
        startActivity(intent);
        finish();
    }

    public void AboutUs(View view)
    {
        Intent intent = new Intent(this, AboutView.class);
        startActivity(intent);
    }

    public void AboutCit(View view)
    {
        OkDialog okDialog = new OkDialog();
        okDialog.setHead("Гражданин");
        okDialog.setMess("Тип аккаунта для социально-активных людей, не выступающих лицом организации");
        okDialog.show(getFragmentManager(), "okDialog");
    }

    public void AboutOrg(View view)
    {
        OkDialog okDialog = new OkDialog();
        okDialog.setHead("Организация");
        okDialog.setMess("Тип аккаунта для человека, выступающего лицом благотворительного фонда, организации или социальной службы");
        okDialog.show(getFragmentManager(), "okDialog");
    }

}
