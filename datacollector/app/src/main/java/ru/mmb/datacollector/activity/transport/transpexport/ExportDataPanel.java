package ru.mmb.datacollector.activity.transport.transpexport;

import static ru.mmb.datacollector.activity.Constants.KEY_EXPORT_RESULT_MESSAGE;
import ru.mmb.datacollector.R;
import ru.mmb.datacollector.model.registry.Settings;
import ru.mmb.datacollector.transport.exporter.ExportFormat;
import ru.mmb.datacollector.transport.exporter.ExportMode;
import ru.mmb.datacollector.transport.exporter.ExportState;
import android.os.Handler;
import android.os.Message;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.RadioButton;
import android.widget.TextView;
import android.widget.Toast;

public class ExportDataPanel
{
	private final TransportExportActivity activity;

	private final TextView labLastExportDate;
	private final RadioButton radioFormatTxt;
	private final RadioButton radioFormatJson;
	private final Button btnFullExport;
	private final Button btnIncrementalExport;

	private final Handler exportFinishHandler;

	public ExportDataPanel(TransportExportActivity activity)
	{
		this.activity = activity;

		labLastExportDate =
		    (TextView) activity.findViewById(R.id.transpExportData_lastExportTextView);
		radioFormatTxt = (RadioButton) activity.findViewById(R.id.transpExportData_formatTxtRadio);
		radioFormatJson =
		    (RadioButton) activity.findViewById(R.id.transpExportData_formatJsonRadio);
		btnFullExport = (Button) activity.findViewById(R.id.transpExportData_fullExportBtn);
		btnIncrementalExport =
		    (Button) activity.findViewById(R.id.transpExportData_incrementalExportBtn);

		radioFormatTxt.setOnClickListener(new FormatRadioClickListener());
		radioFormatJson.setOnClickListener(new FormatRadioClickListener());
		btnFullExport.setOnClickListener(new FullClickListener());
		btnIncrementalExport.setOnClickListener(new IncrementalClickListener());

		exportFinishHandler = new Handler()
		{
			@Override
			public void handleMessage(Message msg)
			{
				if (getExportState() != null && !getExportState().isTerminated())
				{
					String resultMessage = msg.getData().getString(KEY_EXPORT_RESULT_MESSAGE);
					Toast.makeText(getActivity().getApplicationContext(), resultMessage, Toast.LENGTH_LONG).show();
				}
				setExportState(null);
				getActivity().refreshState();
			}
		};
	}

	private TransportExportActivity getActivity()
	{
		return activity;
	}

	private ExportState getExportState()
	{
		return activity.getExportState();
	}

	private void setExportState(ExportState exportState)
	{
		activity.setExportState(exportState);
	}

	public void refreshState()
	{
		refreshLastExportDate();
		refreshRadioState();
		buttonsSetEnabled();
	}

	private void refreshLastExportDate()
	{
		String lastExportString = Settings.getInstance().getLastExportDate();
		if ("".equals(lastExportString))
		{
			labLastExportDate.setText(activity.getResources().getText(R.string.transp_export_data_no_last_export));
		}
		else
		{
			labLastExportDate.setText(lastExportString);
		}
	}

	private void refreshRadioState()
	{
		if (activity.getCurrentState().getExportFormat() == ExportFormat.TXT)
		{
			radioFormatTxt.setChecked(true);
		}
		else
		{
			radioFormatJson.setChecked(true);
		}
	}

	private void buttonsSetEnabled()
	{
		radioFormatTxt.setEnabled(getExportState() == null);
		radioFormatJson.setEnabled(getExportState() == null);
		btnFullExport.setEnabled(getExportState() == null);
		btnIncrementalExport.setEnabled(getExportState() == null);
	}

	private void runExport(ExportMode exportMode)
	{
		setExportState(new ExportState());
		getActivity().refreshState();

		ExportDataThread thread =
		    new ExportDataThread(getActivity(), exportFinishHandler, exportMode, getExportState(), activity.getCurrentState().getExportFormat());
		thread.start();
	}

	private class FormatRadioClickListener implements OnClickListener
	{
		@Override
		public void onClick(View v)
		{
			if (radioFormatTxt.isChecked())
			{
				activity.getCurrentState().setExportFormat(ExportFormat.TXT);
			}
			else
			{
				activity.getCurrentState().setExportFormat(ExportFormat.JSON);
			}
		}
	}

	private class FullClickListener implements OnClickListener
	{
		@Override
		public void onClick(View v)
		{
			runExport(ExportMode.FULL);
		}
	}

	private class IncrementalClickListener implements OnClickListener
	{
		@Override
		public void onClick(View v)
		{
			runExport(ExportMode.INCREMENTAL);
		}
	}
}
