package ru.mmb.datacollector.activity.transport;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;

import ru.mmb.datacollector.R;
import ru.mmb.datacollector.activity.transport.bclogger.receive.TransportLoggerReceiveActivity;
import ru.mmb.datacollector.activity.transport.http.receive.TransportHttpReceiveActivity;
import ru.mmb.datacollector.activity.transport.transpimport.TransportImportActivity;
import ru.mmb.datacollector.model.registry.Settings;

public class TransportReportActivity extends Activity {
    private Button btnImportDictionaries;
    private Button btnReceiveFromServer;
    private Button btnReceiveLoggerData;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        Settings.getInstance().setCurrentContext(this);

        setContentView(R.layout.transport_report);

        btnImportDictionaries = (Button) findViewById(R.id.transportReport_importDictionariesBtn);
        btnReceiveFromServer = (Button) findViewById(R.id.transportReport_receiveFromServerBtn);
        btnReceiveLoggerData = (Button) findViewById(R.id.transportReport_receiveLoggerDataBtn);

        btnImportDictionaries.setOnClickListener(new ImportDictionariesClickListener());
        btnReceiveFromServer.setOnClickListener(new ReceiveFromServerClickListener());
        btnReceiveLoggerData.setOnClickListener(new ReceiveLoggerDataClickListener());
    }

    private class ImportDictionariesClickListener implements View.OnClickListener {
        @Override
        public void onClick(View v) {
            Intent intent = new Intent(getApplicationContext(), TransportImportActivity.class);
            startActivity(intent);
        }
    }

    private class ReceiveFromServerClickListener implements View.OnClickListener {
        @Override
        public void onClick(View v) {
            Intent intent = new Intent(getApplicationContext(), TransportHttpReceiveActivity.class);
            startActivity(intent);
        }
    }

    private class ReceiveLoggerDataClickListener implements View.OnClickListener {
        @Override
        public void onClick(View v) {
            Intent intent = new Intent(getApplicationContext(), TransportLoggerReceiveActivity.class);
            startActivity(intent);
        }
    }
}
